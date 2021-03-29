<?php

require 'config.php';

// $_GET['formid'] is the id of the form to display
// $_GET['siteid'] is the id of the site, if this form is being submitted for a particular site

$errors = False;
$siteid = null;

if (isset($_GET['siteid']))
	$siteid = $_GET['siteid'];

if(isset($_POST['formid'])){
    if (isset($_POST['siteid']))
        $siteid = $_POST['siteid'];    
    
    if ($user['role'] == 3)
        $errors = submit_form_for_site($user['id'], $_POST['formid'], $_POST, $siteid);
	
    if ($user['role'] == 2)
        $errors = submit_form($user['id'], $_POST['formid'], $_POST, $siteid);
	
    if ($user['role'] == 1)
	{
		$form = get_form_by_id($_POST['formid']);
		
		if ($form['roleid'] == 1)
			$errors = submit_admin_form($user['id'], $_POST['formid'], $_POST);
		else
			$errors = submit_form_as_admin($user['id'], $_POST['formid'], $_POST, $siteid);
	}
	
	if (!$errors)
	{
        if (isset($_POST['siteid']))
            header("Location: list-forms.php?siteid=".$_POST['siteid']);
        else
            header("Location: list-forms.php");
        
		exit();
	}
}

if ($user['role'] == 3)
    $submitted = get_form_submission_for_site($_GET['form'], $siteid);
else
    $submitted = get_form_submission($user['id'], $_GET['form'], $siteid);

$submissions = array();

if ($submitted)
{
	$temp = get_field_submissions($submitted['id']);
	
	foreach ($temp as $field)
	{
		$submissions[$field['name']] = $field;
	}
}

$types = get_form_field_types();
$fields = get_form_fields($_GET['form']);

echo $twig->render('display-form.html',['fields' => $fields, 'types' => $types, 'form' => $_GET['form'], 'submissions' => $submissions, 'errors' => $errors, 'siteid' => $siteid]);


?>
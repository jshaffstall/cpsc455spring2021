<?php

require 'config.php';
if(!$user)
{
	header("Location:index.php");
	exit();
}
// $_GET['formid'] is the id of the form to display
// $_GET['siteid'] is the id of the site, if this form is being submitted for a particular site

$errors = False;
$siteid = null;
$submissionid = null;

if (isset($_GET['siteid']))
	$siteid = $_GET['siteid'];

if (isset($_GET['submission']))
	$submissionid = $_GET['submission'];

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
			$errors = submit_form_as_admin($user['id'], $_POST['formid'], $_POST, $submissionid, $siteid);
	}
	
	if (!$errors)
	{
        if (isset($_POST['siteid']))
            header("Location: list-forms.php?siteid=".$_POST['siteid']);
        if (isset($_POST['submissionid']))
            header("Location: form-submissions.php");
        else
            header("Location: list-forms.php");
        
		exit();
	}
}

if (! $submissionid)
{
    $form = $_GET['form'];
    
    if ($user['role'] == 3)
        $submitted = get_form_submission_for_site($form, $siteid);
    else
        $submitted = get_form_submission($user['id'], $form, $siteid);
}
else
{
     $submitted = get_form_submission_by_id($submissionid);
     $form = $submitted['formid'];
}
 
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
$fields = get_form_fields($form);
$form = get_form_by_id($form);

echo $twig->render('display-form.html',['fields' => $fields, 'types' => $types, 'form' => $form, 'submissions' => $submissions, 'errors' => $errors, 'siteid' => $siteid, 'submissionid' => $submissionid]);


?>
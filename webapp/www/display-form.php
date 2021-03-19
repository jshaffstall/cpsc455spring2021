<?php

require 'config.php';

// $_GET['formid'] is the id of the form to display
// $_GET['siteid'] is the id of the site, if this form is being submitted for a particular site

$errors = False;
$siteid = null;

if (isset($_GET['siteid']))
	$siteid = $_GET['siteid'];

if(isset($_POST['formid'])){
	$errors = submit_form($user['id'], $_POST['formid'], $_POST, $siteid);
	
	if (!$errors)
	{
        if (isset($_POST['siteid']))
            header("Location: list-forms.php?siteid=".$_POST['siteid']);
        else
            header("Location: list-forms.php");
        
		exit();
	}
}

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
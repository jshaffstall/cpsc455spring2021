<?php

require 'config.php';

// $_GET['submission'] is the id of the submission to display

if(! isset($_GET['submission'])){
    header("Location: index.php");
	exit();
}

$submitted = get_form_submission_by_id($_GET['submission']);
$student = [];

$submissions = array();

if ($submitted)
{
    $student = get_user_by_id($submitted['user']);
    $form = get_form_by_id($submitted['formid']);
    
	$temp = get_field_submissions($submitted['id']);
	
	foreach ($temp as $field)
	{
		$submissions[$field['name']] = $field;
	}
}

$types = get_form_field_types();
$fields = get_form_fields($submitted ['formid']);

echo $twig->render('display-submission.html',['fields' => $fields, 'types' => $types, 'submissions' => $submissions, 'student' => $student, 'form' => $form]);


?>
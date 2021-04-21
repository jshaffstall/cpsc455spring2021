<?php

require 'config.php';

// $_GET['submission'] is the id of the submission to display

if(! $user || ! isset($_GET['submission'])){
    header("Location: index.php");
	exit();
}

$submitted = get_form_submission_by_id($_GET['submission']);
$student = [];
$form = [];

$submissions = array();

if ($submitted)
{
    $student = get_user_by_id($submitted['user']);
    $form = get_form_by_id($submitted['formid']);
	
	if ($user['role'] == 2)
	{
		// Students should be able to see forms they submitted, or admin forms
		// For any other forms, redirect them to the home page
		if ($submitted['user'] != $user['id'] && $form['roleid'] != 1)
		{
			header("Location: index.php");
			exit();
		}
	}
    
	if ($user['role'] == 3)
	{
		// Site owners should be able to see forms for their site, or admin forms,
		// or student forms that are visible to sites for students that are assigned to their site
		// For any other forms, redirect them to the home page
		$sitematch = False;
		
		$sites = get_sites_for_user($user['id']);
		
		foreach ($sites as $site)
		{
			if ($sitematch)
				break;
			
			if ($site['id'] == $submitted['siteid'])
				$sitematch = True;
			
			$students = get_users_for_site($site['id'], 2);
			
			foreach ($students as $student)
			{
				if ($student['id'] == $submitted['user'] && $form['sitevisible'])
					$sitematch = True;
			}
		}
		
		if (! $sitematch && $form['roleid'] != 1)
		{
			header("Location: index.php");
			exit();
		}
	}
	
	// Admins can see any forms, so no need to check for them
	
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
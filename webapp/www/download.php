<?php

require 'config.php';

if (isset($_GET['id']) && $user)
{
	$submission = get_field_submission($_GET['id']);
	
	if ($submission)
	{
		$formsubmission = get_form_submission_by_id($submission['formsubmissionid']);
		$form = get_form_by_id($formsubmission['formid']);
		
		if ($user['role'] == 2)
		{
			// Students should be able to see forms they submitted, or admin forms
			// For any other forms, redirect them to the home page
			if ($formsubmission['user'] != $user['id'] && $form['roleid'] != 1)
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
		
		
		header("Content-length: ".$submission['size']);
		header("Content-type: ".$submission['content_type']);
		header("Content-Disposition: attachment; filename=".$submission['value']);	
		
		echo $submission['file'];
		
		exit ();
	}
}

header("Location: index.php");

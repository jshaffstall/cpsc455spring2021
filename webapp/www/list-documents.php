<?php

require 'config.php';

$forms = [];

if ($user)
{
    $forms = get_admin_forms();
    
	if ($user['role'] == 1)
    {
        echo $twig->render('list-forms.html',['forms' => $forms, 'title' => "Documents"]);
        exit();
    }
	
	$submissions = [];
	
	foreach ($forms as $form)
	{
		$submission = get_admin_form_submission($form['id']);
		$submissions[] = ['id'=>$submission['id'], 'name'=>$form['name']];
	}
	
	echo $twig->render('list-admin-submissions.html',['submissions' => $submissions, 'title' => "Documents"]);	
}



?>
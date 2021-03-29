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
}

echo $twig->render('list-submissions.html',['forms' => $forms, 'title' => "Documents"]);

?>
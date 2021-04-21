<?php
require 'config.php';

if (! ($user && $user['role'] == 1))
{
    header ("Location: index.php");
    exit();
}

$formSubmissions = get_all_form_submissions();
//$formSubmissions = get_form_submissions(1);
echo $twig->render('form-submissions.html', ['formSubmissions' => $formSubmissions]);


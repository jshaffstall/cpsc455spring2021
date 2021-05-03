<?php
require 'config.php';

if (! ($user && $user['role'] == 1))
{
    header ("Location: index.php");
    exit();
}

$user = null;

if (isset($_GET['user']))
	$user = get_user_by_id($_GET['user']);

if ($user)
    $formSubmissions = get_form_submissions($user['id']);
else
    $formSubmissions = get_all_form_submissions();

echo $twig->render('form-submissions.html', ['formSubmissions' => $formSubmissions, 'user' => $user]);


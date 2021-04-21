<?php

require 'config.php';

if (! ($user && $user['role'] == 1))
{
    header ("Location: index.php");
    exit();
}

global $message;
$userid = $_GET['id'];
$user = get_user_by_id($userid);

if (isset($_POST['submitPassword'])) {
	global $message;
	
	$email = $user['email'];
	$password = $_POST['password'];
	$confirmPassword = $_POST['confirmPassword'];
	
	if (strcmp($password, $confirmPassword) != 0) {
		$message = "Error: passwords do not match";
	}
	else if ($password == "") {
		$message = "Error: password cannot be empty";
	}
	else {
		set_user_password ($email, $password);
		$message = "Password successfully reset";
	}
}

echo $twig->render('admin-reset-user-password.html', ['user' => $user, 'message' => $message]);

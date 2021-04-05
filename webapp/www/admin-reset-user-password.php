<?php

require 'config.php';
$userid = $_GET['id'];
$user = get_user_by_id($userid);

echo $twig->render('admin-reset-user-password.html', ['user' => $user]);

if (isset($_POST['submitPassword'])) {
	$email = $user['email'];
	$password = $_POST['password'];
	set_user_password ($email, $password);
	echo "reset user pw";
}

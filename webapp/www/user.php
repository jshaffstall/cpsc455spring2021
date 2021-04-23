<?php

require 'config.php';

if (! ($user && $user['role'] == 1))
{
    header ("Location: index.php");
    exit();
}

$userid = $_GET['id'];
$currentUser = get_user_by_id ($userid);
$error = null;

if (isset($_POST['delete'])) {
	if ($userid == $user['id']) {
		$error = "You cannot delete yourself";
	}
	else {
		delete_user($userid);
		header("Location: users.php");
	}
}

echo $twig->render('user.html', ['user' => $currentUser, 'error' => $error]);

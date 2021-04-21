<?php

require 'config.php';

if (! ($user && $user['role'] == 1))
{
    header ("Location: index.php");
    exit();
}

$userid = $_GET['id'];
$currentUser = get_user_by_id ($userid);
echo $twig->render('user.html', ['user' => $currentUser]);

if (isset($_POST['delete'])) {
	if ($userid == $user['id']) {
		echo "You cannot delete yourself";
	}
	else {
		delete_user($userid);
		header("Location: users.php");
	}
}

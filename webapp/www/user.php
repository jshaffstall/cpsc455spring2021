<?php

require 'config.php';

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

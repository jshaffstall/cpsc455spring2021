<?php

require 'config.php';

$userid = $_GET['id'];
$user = get_user_by_id ($userid);
echo $twig->render('user.html', ['user' => $user]);

if (isset($_POST['delete'])) {
	delete_user($userid);
	header("Location: users.php");
}

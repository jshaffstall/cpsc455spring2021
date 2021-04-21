<?php

require 'config.php';

if (! ($user && $user['role'] == 1))
{
    header ("Location: index.php");
    exit();
}

// show disabled users so that we can enable them
$disabledUsers = get_users(1);

echo $twig->render('users-enable.html', ['disabledUsers' => $disabledUsers]);

if (isset($_POST['submitEnableUsers'])) {
	$usersToEnable = $_POST['usersToEnable'];
	
	foreach ($usersToEnable as $userId) {
		enable_user($userId);
	}
	
	header("Location: users-enable.php");
}
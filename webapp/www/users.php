<?php

require 'config.php';

$enabledUsers = get_users();
$disabledUsers = get_users(1);

echo $twig->render('users.html', ['enabledUsers' => $enabledUsers, 'disabledUsers' => $disabledUsers]);

if (isset($_POST['submitDisableUsers'])) {
	$usersToDisable = $_POST['usersToDisable'];
	
	foreach ($usersToDisable as $userId) {
		disable_user($userId);
		header("Location: users.php");
	}
}

else if (isset($_POST['submitEnableUsers'])) {
	$usersToEnable = $_POST['usersToEnable'];
	
	foreach ($usersToEnable as $userId) {
		enable_user($userId);
		header("Location: users.php");
	}
}
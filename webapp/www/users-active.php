<?php

require 'config.php';

$enabledUsers = get_users();
$disabledUsers = get_users(1);

$admins = get_users_by_role(1, true);
$students = get_users_by_role(2, true);
$fieldsites = get_users_by_role(3, true);

echo $twig->render('users-active.html', ['admins' => $admins, 'students' => $students, 'fieldsites' => $fieldsites, 'enabledUsers' => $enabledUsers, 'disabledUsers' => $disabledUsers]);

if (isset($_POST['submitDisableUsers'])) {
	$usersToDisable = $_POST['usersToDisable'];
	
	foreach ($usersToDisable as $userId) {
		disable_user($userId);
		header("Location: users-active.php");
	}
}

else if (isset($_POST['submitEnableUsers'])) {
	$usersToEnable = $_POST['usersToEnable'];
	
	foreach ($usersToEnable as $userId) {
		enable_user($userId);
	}
	
	header("Location: users-active.php");
}
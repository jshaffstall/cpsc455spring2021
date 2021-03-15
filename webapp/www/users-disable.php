<?php

require 'config.php';

// show enabled users so that we can disable them
$enabledUsers = get_users();

echo $twig->render('users-disable.html', ['enabledUsers' => $enabledUsers]);

if (isset($_POST['submitDisableUsers'])) {
	$usersToDisable = $_POST['usersToDisable'];
	
	foreach ($usersToDisable as $userId) {
		disable_user($userId);
		header("Location: users-disable.php");
	}
}
<?php

require 'config.php';

if (! ($user && $user['role'] == 1))
{
    header ("Location: index.php");
    exit();
}

$enabledUsers = get_users();
$disabledUsers = get_users(1);

$admins = get_users_by_role(1);
$students = get_users_by_role(2);
$siteUsers = get_users_by_role(3);

$sites = get_sites();

echo $twig->render('users-remove-from-site.html', ['students' => $students, 'siteUsers' => $siteUsers, 'fieldSites' => $sites]);

if (isset($_POST['submitRemoveUsers'])) {
	$usersToRemove = $_POST['usersSelected'];
	$fieldSiteId = $_POST['site'];
	
	foreach ($usersToRemove as $userId) {
		remove_user_from_site ($userId, $fieldSiteId);
	}
	
	header("Location: users-remove-from-site.php");
}



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

if (isset($_POST['submitAssignUsers'])) {
	$usersToAssign = $_POST['usersSelected'];
	$fieldSiteId = $_POST['site'];
	
	foreach ($usersToAssign as $userId) {
		assign_user_to_site ($userId, $fieldSiteId);
	}
	
	header("Location: users-assign-to-site.php");
}

echo $twig->render('users-assign-to-site.html', ['students' => $students->fetchAll(), 'siteUsers' => $siteUsers->fetchAll(), 'fieldSites' => $sites]);



<?php
require 'config.php';

if (! ($user && $user['role'] == 1))
{
    header ("Location: index.php");
    exit();
}

/* 
*	Returns the name and id of all student users and site users in a site
*/

if (isset($_POST['siteId'])) {
	$siteId = $_POST['siteId'];
	
	// students
	$users = get_users_for_site($siteId, 2);

	$result = [];
	$result['students'] = [];
	$result['sites'] = [];

	foreach ($users as $user) {
		$rowresult = [];
		$rowresult['name'] = $user['name'];
		$rowresult['id'] = $user['id'];
		
		$result['students'][] = $rowresult;
	}

	// field site users
	$users = get_users_for_site($siteId, 3);

	foreach ($users as $user) {
		$rowresult = [];
		$rowresult['name'] = $user['name'];
		$rowresult['id'] = $user['id'];
		
		$result['sites'][] = $rowresult;
	}

	echo json_encode($result);
}


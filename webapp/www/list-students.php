<?php

require 'config.php';
if(!$user || $user['role'] == 1)
{
	header("Location:index.php");
	exit();
}
$students = [];
$siteid = False;

if (isset($_GET['siteid']))
	$siteid = $_GET['siteid'];

if ($siteid)
{
	$site = get_site_by_id($siteid);
	$students = get_users_for_site($siteid, 2);
}

echo $twig->render('list-students.html',['students' => $students, 'site' => $site]);

?>
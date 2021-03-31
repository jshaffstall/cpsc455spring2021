<?php

require 'config.php';

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
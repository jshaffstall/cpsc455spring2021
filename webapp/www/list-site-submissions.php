<?php

require 'config.php';
if(!($user && $user['role'] == 1 || $user['role'] == 2))
{
	header("Location:index.php");
	exit();
}
$students = [];
$studentsubs = [];
$sitesubs = [];

$siteid = False;

if (isset($_GET['siteid']))
	$siteid = $_GET['siteid'];

$student = get_user_by_id($_GET['user']);

if ($siteid)
{
	$site = get_site_by_id($siteid);
    
    $studentsubs = get_form_submissions_visible_to_sites($_GET['user']);
    $sitesubs = get_student_form_submissions_for_site($_GET['user'], $siteid);
}

echo $twig->render('list-site-submissions.html',['studentsubmissions' => $studentsubs, 'sitesubmissions' => $sitesubs, 'site' => $site, 'student' => $student]);

?>
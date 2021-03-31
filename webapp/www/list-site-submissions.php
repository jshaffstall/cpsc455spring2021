<?php

require 'config.php';

$students = [];
$siteid = False;

if (isset($_GET['siteid']))
	$siteid = $_GET['siteid'];

if ($siteid)
{
	$site = get_site_by_id($siteid);
	// TODO: Need db function to grab student form submissions that site admins can see
	// TODO: Need db function to grab site form submissions that students fill out for a particular student
}

echo $twig->render('list-site-submissions.html',['studentsubmissions' => $studentsubs, 'sitesubmissions' => $sitesubs, 'site' => $site]);

?>
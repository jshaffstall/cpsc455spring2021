<?php

require 'config.php';

// $_GET['siteid'] is the id of the site, if these forms are part of a site.  If not present, these forms are generic student forms.

$forms = [];
$siteid = False;

if (isset($_GET['siteid']))
	$siteid = $_GET['siteid'];

if ($user)
{
	if ($user['role'] == 1)
		$forms = get_forms();
	
	if ($user['role'] == 2)
		if ($siteid)
			$forms = get_site_forms_for_students();
		else
			$forms = get_student_forms();
	
	if ($user['role'] == 3)
		$forms = get_site_forms();
}

echo $twig->render('list-forms.html',['forms' => $forms, 'siteid' => $siteid]);

?>
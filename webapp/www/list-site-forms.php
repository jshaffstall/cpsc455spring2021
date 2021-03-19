<?php

require 'config.php';

$forms = [];

if ($user && isset($_GET['site']))
{
	if ($user['role'] == 2)
		$forms = get_site_forms_for_students();
	
	if ($user['role'] == 3)
		$forms = get_site_forms();
}

echo $twig->render('list-forms.html',['forms' => $forms]);

?>
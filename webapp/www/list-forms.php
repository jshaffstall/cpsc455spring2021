<?php

require 'config.php';

$forms = [];

if ($user)
{
	if ($user['role'] == 1)
		$forms = get_forms();
	
	if ($user['role'] == 2)
		$forms = get_student_forms();
	
	if ($user['role'] == 3)
		$forms = get_site_forms();
}

echo $twig->render('list-forms.html',['forms' => $forms]);

?>
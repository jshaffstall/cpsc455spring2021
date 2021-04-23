<?php
require 'config.php';

if (! ($user && $user['role'] == 1))
{
    header ("Location: index.php");
    exit();
}

if (isset($_POST['submitUnarchiveForms'])) {
	$formsToUnarchive = $_POST['formsToUnarchive'];
	
	foreach ($formsToUnarchive as $formid) {
		unarchive_form($formid);
	}
	
	header("Location: unarchive-forms.php");
}

$forms = get_archived_forms();

echo $twig->render('unarchive-forms.html', ['forms' => $forms]);



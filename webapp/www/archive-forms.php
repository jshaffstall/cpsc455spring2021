<?php
require 'config.php';

if (! ($user && $user['role'] == 1))
{
    header ("Location: index.php");
    exit();
}

if (isset($_POST['submitArchiveForms'])) {
	$formsToArchive = $_POST['formsToArchive'];
	
	foreach ($formsToArchive as $formid) {
		archive_form($formid);
	}
	
	header("Location: archive-forms.php");
}

$forms = get_forms();

echo $twig->render('archive-forms.html', ['forms' => $forms]);



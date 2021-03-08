<?php
global $twig;
global $form;
require 'config.php';

// get form info
$siteName = $_GET["site"];
$site = get_site($siteName);

if ($site) {
	$webpage = $twig->render('site-editor.html',['site' => $site]);
	echo "$webpage";
}
else {
	// TODO echo webpage with error
	echo "Form does not exist";
}

if (isset($_POST['submitSite'])) {
	editSite();
}

function editSite() {
	global $site;
	
	$siteName = $_POST["siteName"];
	
	// return false if form of same name
	update_site($site["id"], $siteName);
	
	header("Location: site-editor.php?site=$siteName");
}
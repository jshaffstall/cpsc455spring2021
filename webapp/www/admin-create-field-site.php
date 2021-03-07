<?php
require 'config.php';
//$sites = 
echo $twig->render('admin-create-field-site.html', ["sites" => $sites]);

if (isset($_POST["submitSite"])) {
	$siteName = $_POST["siteName"];
	add_site($siteName);
}

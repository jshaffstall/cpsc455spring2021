<?php
require 'config.php';
$sites = get_sites();
echo $twig->render('admin-create-field-site.html', ["sites" => $sites]);

if (isset($_POST["submitSite"])) {
	$siteName = $_POST["siteName"];
	add_site($siteName);
}

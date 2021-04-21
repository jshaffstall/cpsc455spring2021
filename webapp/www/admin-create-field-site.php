<?php
require 'config.php';

if (! ($user && $user['role'] == 1))
{
    header ("Location: index.php");
    exit();
}

$sites = get_sites();
echo $twig->render('admin-create-field-site.html', ["sites" => $sites]);

if (isset($_POST["submitSite"])) {
	$siteName = $_POST["siteName"];
	add_site($siteName);
	header("Location: admin-create-field-site.php");
}

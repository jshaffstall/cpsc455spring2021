<?php

require 'config.php';

if (! ($user && $user['role'] == 1))
{
    header ("Location: index.php");
    exit();
}

$siteName = $_GET['site'];
$site = get_site($siteName);
echo $twig->render('field-site.html', ['site' => $site]);

if (isset($_POST['delete'])) {
	$siteId = $site['id'];
	
	delete_site($siteId);
	header("Location: field-sites.php");
}

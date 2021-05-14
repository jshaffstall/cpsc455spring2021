<?php

require 'config.php';
if(!$user || $user['role'] == 1)
{
	header("Location:index.php");
	exit();
}
$sites = get_sites();
$siteAssigned = get_sites_for_user($user['id']);

echo $twig->render('list-sites.html',['sites' => $sites, 'siteAssigned' => $siteAssigned]);

?>
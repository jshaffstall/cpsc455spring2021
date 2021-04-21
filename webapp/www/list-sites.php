<?php

require 'config.php';
if(!($user && $user['role'] == 1 || $user['role'] == 2))
{
$sites = get_sites();
$siteAssigned = get_sites_for_user($user['id']);

echo $twig->render('list-sites.html',['sites' => $sites, 'siteAssigned' => $siteAssigned]);
}
?>
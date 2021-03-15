<?php

require 'config.php';

$sites = get_sites();
$siteAssigned = get_sites_for_user($user['id']);

echo $twig->render('list-sites.html',['sites' => $sites, 'siteAssigned' => $siteAssigned]);

?>
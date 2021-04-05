<?php
require 'config.php';
$sites = get_sites();
echo $twig->render('field-sites.html', ["sites" => $sites]);

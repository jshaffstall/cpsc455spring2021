<?php
require 'config.php';

if (! ($user && $user['role'] == 1))
{
    header ("Location: index.php");
    exit();
}

$sites = get_sites();
echo $twig->render('field-sites.html', ["sites" => $sites]);

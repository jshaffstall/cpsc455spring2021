<?php

require_once 'vendor/autoload.php';

if (!isset($TEMPLATES))
    $TEMPLATES = '../includes/templates/';

if (!isset($INCLUDES))
    $INCLUDES = '../includes/';

if (!isset($twig))
{
    $twigloader = new \Twig\Loader\FilesystemLoader($TEMPLATES);
    $twig = new \Twig\Environment($twigloader, ['cache' => False,]);
}

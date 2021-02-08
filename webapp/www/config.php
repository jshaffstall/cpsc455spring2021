<?php

require_once 'vendor/autoload.php';

if (!isset($TEMPLATES))
    $TEMPLATES = '../includes/templates/';

if (!isset($INCLUDES))
    $INCLUDES = '../includes/';

require_once $INCLUDES.'db.php';

session_start();

if (isset($_SESSION['user']))
	$user = get_user($_SESSION['user']);
else
	$user = False;

if (!isset($twig))
{
    $twigloader = new \Twig\Loader\FilesystemLoader($TEMPLATES);
    $twig = new \Twig\Environment($twigloader, ['cache' => False]);
    $twig->addGlobal('user', $user);
}

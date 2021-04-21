<?php
require 'config.php';

if (! ($user && $user['role'] == 1))
{
header ("Location: index.php");
exit();
}

echo $twig->render('admin-panel.html');
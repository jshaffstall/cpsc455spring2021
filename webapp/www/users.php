<?php

require 'config.php';

$enabledUsers = get_users();
$disabledUsers = get_users(1);

echo $twig->render('users.html', ['enabledUsers' => $enabledUsers, 'disabledUsers' => $disabledUsers]);
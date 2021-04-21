<?php

require 'config.php';

if (! ($user && $user['role'] == 1))
{
    header ("Location: index.php");
    exit();
}

$enabledUsers = get_users();
$disabledUsers = get_users(1);

$admins = get_users_by_role(1);
$students = get_users_by_role(2);
$fieldsites = get_users_by_role(3);

echo $twig->render('users.html', ['admins' => $admins, 'students' => $students, 'fieldsites' => $fieldsites]);

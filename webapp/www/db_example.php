<?php

// This is an example showing how to use the db functions

require 'config.php';

$roles = get_roles();
$types = get_form_field_types();

if (login_user('admin@muskingum.edu', 'password'))
    $success_status = 'Logged in with password';
else
    $success_status = 'Could not login with password';
    
if (login_user('admin@muskingum.edu', 'notthepassword'))
    $fail_status = 'Logged in with notthepassword';
else
    $fail_status = 'Could not login with notthepassword';

echo $twig->render('db_example.html', ['roles' => $roles, 'success_status' => $success_status, 'fail_status' => $fail_status, 'types' => $types]);

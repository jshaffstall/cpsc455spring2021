<?php

// This is an example showing how to use the db functions

require 'config.php';

$roles = get_roles();
$types = get_form_field_types();
$forms = get_forms();
$fields = get_form_fields(1);
$field = get_form_field(1);

$users = get_users();
$inactive = get_users(true);

echo $twig->render('db_example.html', ['roles' => $roles, 'types' => $types, 'forms' => $forms, 'fields' => $fields, 'users' => $users, 'inactive' => $inactive]);

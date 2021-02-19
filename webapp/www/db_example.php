<?php

// This is an example showing how to use the db functions

require 'config.php';

$roles = get_roles();
$types = get_form_field_types();
$forms = get_forms();
$fields = get_form_fields(1);
$field = get_form_field(1);

echo add_form_field (1, 1, 'label', '', 1, 'foo');
echo add_form_field (1, 1, 'label', '', 1, 'foo');
update_form_field (1, 2, 1, 'label 2', '', 1, 'foo2');

echo $twig->render('db_example.html', ['roles' => $roles, 'types' => $types, 'forms' => $forms, 'fields' => $fields]);

<?php

require 'config.php';
	
$forms = get_forms();
$fields = get_form_fields(1);
$types = get_form_field_types();

echo $twig->render('display-form.html',['forms' => $forms, 'fields' => $fields, 'types' => $types]);

?>
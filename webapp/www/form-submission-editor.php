<?php
require 'config.php';

$formSubmissionId = $_GET["submission"];
$types = get_form_field_types();
$fields = get_form_fields($_GET['formSubmissionId']);

//$formSubmissions = get_form_submissions(1);
echo $twig->render('display-form.html', ['fields' => $fields, 'types' => $types]);
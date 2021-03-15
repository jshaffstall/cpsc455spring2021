<?php

require 'config.php';

$forms = get_forms();
$studentForms = get_student_forms();
$siteForms = get_site_forms();

echo $twig->render('list-forms.html',['forms' => $forms, 'studentForms' => $studentForms, 'siteForms' => $siteForms]);

?>
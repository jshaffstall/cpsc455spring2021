<?php
require 'config.php';

$formSubmissions = get_all_form_submissions();
//$formSubmissions = get_form_submissions(1);
echo $twig->render('form-submissions.html', ['formSubmissions' => $formSubmissions]);


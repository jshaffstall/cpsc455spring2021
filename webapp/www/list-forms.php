<?php

require 'config.php';

$forms = get_forms();

echo $twig->render('list-forms.html',['forms' => $forms]);

?>
<?php

require 'config.php';
if(!($user && $user['role'] == 1))
{
$fields = get_form_fields($_GET['form']);

	echo $twig->render('search-form.html',['form' => $_GET['form'], 'fields' => $fields]);
}
?>
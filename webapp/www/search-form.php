<?php

require 'config.php';
if(!($user && $user['role'] == 1))
{
	header("Location:index.php");
	exit();
}
$fields = get_form_fields($_GET['form']);

	echo $twig->render('search-form.html',['form' => $_GET['form'], 'fields' => $fields]);

?>
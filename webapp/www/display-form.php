<?php

require 'config.php';

//var_dump($_GET);


if(isset($_POST['formid'])){
	$submit = submit_form($user['id'], $_POST['formid'], $_POST);
	//header("Location: list-forms.php");
}
else{
	$_GET['form'];
	$types = get_form_field_types();
	$fields = get_form_fields($_GET['form']);
	
	echo $twig->render('display-form.html',['fields' => $fields, 'types' => $types, 'form' => $_GET['form']]);
}



?>
<?php

require 'config.php';

//var_dump($_GET);

$submitted = get_form_submission($user['id'], 4, null);

if(! $submitted){
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
}
else{
	$submissions = get_field_submissions(1);
	$temp = array();
	for ($submissions){
		$temp[$submissions['name']] = $submissions;
	}
	var_dump($temp);
	exit();
	
}


?>
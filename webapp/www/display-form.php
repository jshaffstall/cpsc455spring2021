<?php

require 'config.php';

//var_dump($_GET);

if(isset($_POST['formid'])){
	$submit = submit_form($user['id'], $_POST['formid'], $_POST);
	//header("Location: list-forms.php");
}

$submitted = get_form_submission($user['id'], $_GET['form'], null);

$submissions = array();

if ($submitted)
{
	$temp = get_field_submissions($submitted['id']);
	
	foreach ($temp as $field)
	{
		$submissions[$field['name']] = $field;
	}
}

$types = get_form_field_types();
$fields = get_form_fields($_GET['form']);

echo $twig->render('display-form.html',['fields' => $fields, 'types' => $types, 'form' => $_GET['form'], 'submissions' => $submissions]);


?>
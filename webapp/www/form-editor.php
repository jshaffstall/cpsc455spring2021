<?php
global $twig;
global $form;
require 'config.php';

// get form info
$formName = $_GET["form"];
$form = get_form($formName);
$types = get_form_field_types();

$roles = get_roles();
$currentRole = null;

if ($form) {
	$formFields = get_form_fields($form["id"]);
	$currentRole = $form["roleid"];
	
	$webpage = $twig->render('form-editor.html',['form' => $form, 'types' => $types, 'fields' => $formFields, 'roles' => $roles]);
	echo "$webpage";
}
else {
	// TODO echo webpage with error
	echo "Form does not exist";
}

if (isset($_POST['submitForm'])) {
	editForm();
} else if (isset($_POST['submitField'])){
	addFormField();
}

function editForm() {
	global $form;
	
	$formName = $_POST["formName"];
	$role = $_POST["formRole"];
	$forStudent = $_POST["forStudent"];
	
	$oldFormType = get_type_of_form($form["id"]);
	
	// return false if form of same name
	update_form($form["id"], $formName, $role, $forStudent);
	
	header("Location: form-editor.php?form=$formName");
}

function addFormField() {
	global $form;
	
	$type = $_POST["type"];
	$label = $_POST["label"];
	$required = $_POST["required"];
	$order = $_POST["order"];
	$name = $_POST["name"];
	$eol = $_POST["eol"];
	$size = $_POST["size"];
	
	//todo error checking
	add_form_field ($form["id"], $type, $label, $order, $name, $eol, $size, $required);
	
	// refresh page to show new field
	$name = $form['name'];
	header("Location: form-editor.php?form=$name");
}
?>
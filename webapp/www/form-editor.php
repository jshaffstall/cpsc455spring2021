<?php
global $twig;
global $form;
global $formId;
require 'config.php';

// get form info
$formId = $_GET["form"];
$form = get_form_by_id($formId);
$types = get_form_field_types();

$roles = get_roles();
$currentRole = null;

if (isset($_POST['submitForm'])) {
	editForm();
} 
else if (isset($_POST['submitField'])) {
	addFormField();
}
else if (isset($_POST['delete'])) {
	delete_form($formId);
	
	header("Location: form-creator.php");
}

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

function editForm() {
	global $form;
	
	$formName = $_POST["formName"];
	$role = $_POST["formRole"];
	$forStudent = $_POST["forStudent"];
	$siteVisible = $_POST["siteVisible"];
	$siteId = $_POST["siteId"];
	
	// return false if form of same name
	// $test = update_form($form["id"], $formName, $role, $forStudent);
	
	$test = update_form($form["id"], $formName, $role, $forStudent, $siteVisible, $siteId);
	var_dump($test);
	$id = $form["id"];
	
	//header("Location: form-editor.php?form=$id");
}

function addFormField() {
	global $form;
	global $formId;
	
	$type = $_POST["type"];
	$label = $_POST["label"];
	$required = $_POST["required"];
	$order = $_POST["order"];
	$name = $_POST["name"];
	$eol = $_POST["eol"];
	$size = $_POST["size"];
	
	//todo error checking
	add_form_field ($formId, $type, $label, $order, $name, $eol, $size, $required);
	
	// refresh page to show new field
	header("Location: form-editor.php?form=$formId");
}

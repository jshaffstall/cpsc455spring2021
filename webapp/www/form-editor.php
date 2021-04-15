<?php
global $twig;
global $form;
global $formId;
require 'config.php';

// get form info
$formId = $_GET["form"];
$form = get_form_by_id($formId);
$types = get_form_field_types();
$sites = get_sites();
$roles = get_roles();
$currentRole = null;

if (isset($_POST['delete'])) {
	delete_form($formId);
	header("Location: form-creator.php");
}
else if (isset($_POST['editForm'])) {
	editForm();
} 
else if (isset($_POST['submitField'])) {
	addFormField();
}
else if (isset($_POST['delete'])) {
	delete_form($formId);
	
	header("Location: form-creator.php");
}
else if (isset($_POST['orderDown'])) {
	$formId = $_GET["form"];

	$order = $_POST['fieldOrder'];
	
	$formfield1 = get_form_field_by_order($formId, $order);
	$formfield2 = get_form_field_by_order($formId, $order+1);
	
	update_form_field_order($formfield1['id'], $order+1);
	update_form_field_order($formfield2['id'], $order);
	
}
else if (isset($_POST['orderUp'])) {
	$formId = $_GET["form"];
	
	$order = $_POST['fieldOrder'];
	
	$formfield1 = get_form_field_by_order($formId, $order);
	$formfield2 = get_form_field_by_order($formId, $order-1);
	
	update_form_field_order($formfield1['id'], $order-1);
	update_form_field_order($formfield2['id'], $order);
}

if ($form) {
	$formFields = get_form_fields($form["id"]);
	$formFields = $formFields->fetchAll();
	$currentRole = $form["roleid"];
	
	$webpage = $twig->render('form-editor.html',['form' => $form, 'types' => $types, 'fields' => $formFields, 'roles' => $roles, 'sites' => $sites]);
	echo "$webpage";
}
else {
	// TODO echo webpage with error
	echo "Form does not exist";
}

function editForm() {
	global $form;
	
	$formName = $_POST["formName"];
	$roleId = $_POST["formRole"];
	$forStudent = $_POST["forStudent"];
	$siteVisible = $_POST["siteVisible"];
	
	if ($roleId == 3 && $forStudent) {
		$siteId = null;
	}
	else {
		$siteId = $_POST["siteId"];
	}
	
	// return false if form of same name
	// $test = update_form($form["id"], $formName, $role, $forStudent);
	
	$test = update_form($form["id"], $formName, $roleId, $forStudent, $siteVisible, $siteId);
	var_dump($test);
	$id = $form["id"];
	
	header("Location: form-editor.php?form=$id");
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

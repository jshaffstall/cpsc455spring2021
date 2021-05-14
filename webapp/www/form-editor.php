<?php
global $twig;
global $form;
global $formId;
global $error;
require 'config.php';

if (! ($user && $user['role'] == 1))
{
    header ("Location: index.php");
    exit();
}

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
	$name = $_POST["name"];
	$label = $_POST["label"];
	if (error($name, $label) != "") {

	}
	else {
		addFormField();
	}
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
	
	$webpage = $twig->render('form-editor.html',['form' => $form, 'types' => $types, 'fields' => $formFields, 'roles' => $roles, 'sites' => $sites, 'error' => $error]);
	echo "$webpage";
}
else {
	// TODO echo webpage with error
	echo "Form does not exist";
}

function error($name, $label) {
	if ($name == "") {
		global $error;
		$error = "Name cannot be empty";
	}
	else if ($label == "") {
		global $error;
		$error = "Label cannot be empty";		
	}
	else {
		return "";
	}
}

function editForm() {
	global $form;
	global $error;
	
	$formName = $_POST["formName"];
	$forStudent = $_POST["forStudent"];
	$siteVisible = $_POST["siteVisible"];
	
	if (isset($_POST["formRole"])) {
		$roleId = $_POST["formRole"];
	}
	else {
		$error = "Please select a role";
		return;
	}
	
	$siteId = null;
    
	if ($roleId == 3 && $forStudent && $_POST["siteId"] != "-1") {
		$siteId = $_POST["siteId"];
	}
	
	if ($formName == '') {
		$error = "Please enter a name";
		return;
	}
	
	// return false if form of same name
	$success = update_form($form["id"], $formName, $roleId, $forStudent, $siteVisible, $siteId);
	
	if ($success) {
		$id = $form["id"];
		header("Location: form-editor.php?form=$id");
	}
	else {
		$error = "A form with that name already exists";	
	}
}

function addFormField() {
	global $error;
	global $form;
	global $formId;
	
	$label = $_POST["label"];
	if ($label == "") {
		$error = "Please enter a label";
		return;
	}
	
	$name = $_POST["name"];
	if ($name == "") {
		$error = "Please enter a name";
		return;
	}
	
	$type = $_POST["type"];
	$required = $_POST["required"];
	$eol = $_POST["eol"];
	$size = $_POST["size"];
	
	//todo error checking
	add_form_field ($formId, $type, $label, $name, $eol, $size, $required);
	
	// refresh page to show new field
	header("Location: form-editor.php?form=$formId");
}

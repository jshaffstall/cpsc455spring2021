<?php
global $twig;
global $formName;
global $form;
global $formfield;
global $formfieldId;
global $message;
require 'config.php';

if (! ($user && $user['role'] == 1))
{
    header ("Location: index.php");
    exit();
}

// get form info
$formId = $_GET["form"];
$form = get_form_by_id($formId);
$formfieldId = $_GET["formfield"];
$formfield = get_form_field($formfieldId);
$types = get_form_field_types();



$submitted = false;

if (isset($_POST["submit"])) {
	if (error($_POST["name"], $_POST["label"])) {
		return;
	}
	
	updateFormfield();
}

else if (isset($_POST["delete"])) {
	deleteFormfield();
}

$webpage = $twig->render('form-field-editor.html',['form' => $form, 'field' => $formfield, 'types' => $types, 'message' => $message]);
echo "$webpage";

function updateFormfield() {
	global $form;
	global $formfield;
	global $formfieldId;
	
	$type = $_POST["type"];
	$label = $_POST["label"];
	$required = $_POST["required"];
	$order = $formfield["order"];
	$name = $_POST["name"];
	$eol = $_POST["eol"];
	$size = $_POST["size"];
	

	
	update_form_field($form, $formfieldId, $type, $label, $order, $name, $eol, $size, $required);
	
	$formId= $form['id'];
	header("Location: form-field-editor.php?form=$formId&formfield=$formfieldId");
}

function error($name, $label) {
	if ($name == "") {
		global $message;
		$message = "Name cannot be empty";
	}
	else if ($label == "") {
		global $message;
		$message = "Label cannot be empty";		
	}
	else {
		return false;
	}
}

function deleteFormfield() {
	$formId = $_GET["form"];
	$formfieldId = $_GET["formfield"];
	
	delete_form_field($formfieldId);
	
	header("Location: form-editor.php?form=$formId");
}
?>
<?php
	global $twig;
	global $formName;
	global $form;
	global $formfield;
	global $formfieldId;
	require 'config.php';
	
	// get form info
	$formName = $_GET["form"];
	$form = get_form($formName);
	$formfieldId = $_GET["formfield"];
	$formfield = get_form_field($formfieldId);
	$types = get_form_field_types();
	
	$webpage = $twig->render('form-field-editor.html',['form' => $form, 'field' => $formfield, 'types' => $types]);
	echo "$webpage";
	
	$submitted = false;
	
	if (isset($_POST["type"])) {
		$submitted = true;
	}	
	
	if ($submitted) {
		global $form;
		global $formfield;
		global $formfieldId;
		
		$type = $_POST["type"];
		$label = $_POST["label"];
		$default = $_POST["default"];
		$order = $_POST["order"];
		$name = $_POST["name"];
		$eol = $_POST["eol"];
		
		
		update_form_field($form, $formfieldId, $type, $label, $default, $order, $name, $eol);
		
		$formName = $form['name'];
		header("Location: form-field-editor.php?form=$formName&formfield=$formfieldId");
	}
?>
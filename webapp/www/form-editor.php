<?php
	global $twig;
	global $form;
	require 'config.php';
	
	// get form info
	$formName = $_GET["form"];
	$form = get_form($formName);
	$types = get_form_field_types();
	$formFields = get_form_fields($form["id"]);
	
	$webpage = $twig->render('form-editor.html',['form' => $form, 'types' => $types, 'fields' => $formFields]);
	echo "$webpage";
	
	$submitted = false;
	if (isset($_POST["type"])) {
		$submitted = true;
	}	
	
	if ($submitted) {
		addFormField();
	}
	
	function addFormField() {
		global $form;
		
		$type = $_POST["type"];
		$label = $_POST["label"];
		$default = $_POST["default"];
		$order = $_POST["order"];
		$name = $_POST["name"];
		$eol = $_POST["eol"];
		
		//todo error checking
		add_form_field ($form["id"], $type, $label, $default, $order, $name, $eol);
		
		// refresh page to show new field
		$name = $form['name'];
		header("Location: form-editor.php?form=$name");
	}
?>
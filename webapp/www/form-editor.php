<?php
	global $twig;
	global $form;
	require 'config.php';
	
	// get form info
	$formName = $_GET["form"];
	$form = get_form($formName);
	$types = get_form_field_types();
	$formTypes = get_form_types();
	$currentFormType = null;
	
	if ($form) {
		$formFields = get_form_fields($form["id"]);
		$currentFormType = get_type_of_form($form["id"]);
		
		$webpage = $twig->render('form-editor.html',['form' => $form, 'types' => $types, 'fields' => $formFields, 'formTypes' => $formTypes, 'currentType' => $currentFormType]);
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
		$formName = $_POST["formName"];
		$formType = $_POST["formType"];
		
		// is there a way in the db to edit forms?
	}
	
	function addFormField() {
		global $form;
		
		$type = $_POST["type"];
		$label = $_POST["label"];
		$default = $_POST["default"];
		$order = $_POST["order"];
		$name = $_POST["name"];
		$eol = $_POST["eol"];
		$size = $_POST["size"];
		
		//todo error checking
		add_form_field ($form["id"], $type, $label, $default, $order, $name, $eol, $size);
		
		// refresh page to show new field
		$name = $form['name'];
		header("Location: form-editor.php?form=$name");
	}
?>
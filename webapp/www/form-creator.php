<?php
	global $twig;
	require 'config.php';
	$forms = get_forms();
	$formTypes = get_form_types();
	
	$webpage = $twig->render('form-creator.html', ['forms' => $forms,'formTypes' => $formTypes]);
	echo $webpage;

	$submitted = false;
	
	if (isset($_POST["form"])) {
		$submitted = true;
	}
	
	if ($submitted) {
		createForm();
	}
	
	function createForm() {
		$name = $_POST["form"];
		$type = $_POST["type"];
		$form = add_form($name);
		add_form_of_type($form['id'], $type);
		header("Location: form-creator.php");
	}
?>
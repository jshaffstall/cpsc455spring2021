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
		add_form($name);
		add_form_of_type($name, $type);
		// refresh page to show new form
		// TODO not working properly?
		header("Location: form-creator.php");
	}
?>
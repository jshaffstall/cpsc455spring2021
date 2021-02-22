<?php
	global $twig;
	require 'config.php';
	$forms = get_forms();
	
	$webpage = $twig->render('form-creator.html',['forms' => $forms]);
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
		add_form($name);
		
		// refresh page to show new form
		header("Location: form-creator.php");
		exit();
	}
?>
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
		
		/*
		global $twig;
		echo $twig->render('form-creator.html',['forms' => $forms]);
		exit();
		*/
	}
	
	function createForm() {
		echo "create form called";
		$name = $_POST["form"];
		add_form($name);
	}
?>
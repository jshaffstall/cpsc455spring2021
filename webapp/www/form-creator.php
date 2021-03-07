<?php
global $twig;
require 'config.php';
$forms = get_forms();
$roles = get_roles();

$webpage = $twig->render('form-creator.html', ['forms' => $forms,'roles' => $roles]);
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
	$role = $_POST["role"];
	$forStudent = $_POST["forStudent"];
	
	$form = add_form($name, $role, $forStudent);
	header("Location: form-creator.php");
}
?>
<?php
global $twig;
require 'config.php';
$forms = get_forms();
$roles = get_roles();
$sites = get_sites();

$webpage = $twig->render('form-creator.html', ['forms' => $forms,'roles' => $roles, 'sites' => $sites]);
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
	$roleId = $_POST["role"];
	$forStudent = $_POST["forStudent"];
	$siteVisible = $_POST["siteVisible"];
	
	if ($roleId == 3 && $forStudent) {
		$siteId = null;
	}
	else {
		$siteId = $_POST["siteId"];
	}
	
	add_form($name, $roleId, $forStudent, $siteVisible, $siteId);
	header("Location: form-creator.php");
}
?>
<?php
global $twig;
global $error;
require 'config.php';

if (! ($user && $user['role'] == 1))
{
    header ("Location: index.php");
    exit();
}

$submitted = false;

if (isset($_POST["form"])) {
	$submitted = true;
}

if ($submitted) {
	createForm();
}

$forms = get_forms();
$roles = get_roles();
$sites = get_sites();

$webpage = $twig->render('form-creator.html', ['forms' => $forms,'roles' => $roles, 'sites' => $sites, 'error' => $error]);
echo $webpage;

function createForm() {
	global $error;
	
	$name = $_POST["form"];
	$forStudent = $_POST["forStudent"];
	$siteVisible = $_POST["siteVisible"];
	
	if (isset($_POST["role"])) {
		$roleId = $_POST["role"];
	}
	else {
		$error = "Please select a role";
		return;
	}
	
	if ($roleId == 3 && $forStudent) {
		$siteId = $_POST["siteId"];
	}
	else {
		$siteId = null;
	}
	
	if ($name == '') {
		$error = "Please enter a name";
	}
	else {
		add_form($name, $roleId, $forStudent, $siteVisible, $siteId);
		header("Location: form-creator.php");
	}
}

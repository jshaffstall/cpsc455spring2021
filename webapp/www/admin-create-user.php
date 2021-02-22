<?php
	require 'config.php';
	
	$roles = get_roles();
	$submitted = false;
	
	// TODO: check if valid email
	if (isset($_POST["role"])) {
		$submitted = true;
	}	
	
	if ($submitted) {	
		submitForm();
	}
	
    displayForm();
	
	function displayForm() {
		global $twig;
		global $roles;
		echo $twig->render('admin-create-user-template.html', ['roles' => $roles]);
	}
	
	function displayFormWithMessage($message) {
		global $twig;
		global $roles;
		echo $twig->render('admin-create-user-template.html', ['roles' => $roles, 'message' => $message]);
		exit();
	}
	
	function submitForm() {
		$role = $_POST["role"];
		$name = $_POST["name"];
		$email = $_POST["email"];
		
		validateForm($name, $email, $role);
		checkIfUniqueEmail($name, $email, $role);
		sendEmail($email);
		
		// Report success
		$success = "User was successfully created";
		displayFormWithMessage($success);
	}
	
	function validateForm($name, $email, $role) {
		$error = "";
		
		// An empty role shouldn't happen, but this is here just in case
		if (isEmptyOrWhiteSpace($role)) {
			$error = "Please select a role";
		}
		
		else if (isEmptyOrWhiteSpace($name)) {
			$error = "Please fill in the name field";
		}
		
		else if (isEmptyOrWhiteSpace($email)) {
			$error = "Please fill in the email field";
		}
		
		if ($error != "") {
			displayFormWithMessage($error);
		}
	}
	
	function checkIfUniqueEmail($name, $email, $role) {
		$uniqueEmail = add_user($name, $email, $role);
		
		if (! $uniqueEmail) {
			$error = "User was not created: A user with that email already exists";
			displayFormWithMessage($error);
		}
	}
	
	function sendEmail($email) {
		global $twig;
		global $siteurl;
		
		$token = generateAndSetToken($email);
		
		$message = $twig->render('password-email.html',['token' => $token, 'siteurl' => $siteurl]);
		$subject = "Password reset";
		
		// send email
		mail($email, $subject, $message);
		
		echo $message;
		exit();
	}
	
	function generateAndSetToken($email) {
		$bytes = random_bytes (7);
		$token = bin2hex($bytes);
		
		// If token already exists, create another
		while (get_user_by_token ($token) != false) {
			$bytes = random_bytes (7);
			$token = bin2hex($bytes);
		}
		
		set_user_token ($email, $token);
		
		return $token;
	}
	
	function isEmptyOrWhiteSpace($data) {
		if ($data == '' || ctype_space($data))
			return true;
		
		return false;
	}
?>
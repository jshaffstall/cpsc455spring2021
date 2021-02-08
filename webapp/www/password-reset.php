<?php
	global $twig;
	require 'config.php';
	$token = $_GET['token'];
	
	$submitted = false;
	
	$webpage = $twig->render('password-reset.html',['token' => $token]);
	echo $webpage;
		
	if (isset($_POST["password"])) {
		$submitted = true;
	}
	
	if ($submitted) {
		submitPassword();
	}
	
	function submitPassword() {
		$token = $_GET['token'];

		$password = $_POST["password"];
		$confirmedPassword = $_POST["confirmedPassword"];
		
		$match = strcmp($password, $confirmedPassword);
		
		# TODO make min pass length
		
		// passwords match
		if ($match == 0) {
			$user = get_user_by_token ($token);
			$email = $user['email'];
			
			set_user_password ($email, $password);
			echo "Successfully changed password";
			clear_user_token($email);
			//TODO kick them to homescreen or somewhere
		}
		else {
			// TODO error message
			echo "Passwords don't match";
		}
	}
	
?>


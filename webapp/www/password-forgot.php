<?php
	global $twig;
	require 'config.php';
	
	$webpage = $twig->render('password-forgot.html');
	echo $webpage;
	
	$submitted = false;
	
	if (isset($_POST["email"])) {
		$submitted = true;
	}
	
	if ($submitted) {
		$email = $_POST["email"];
		
		if (get_user($email) != false) {
			sendEmail($email);
		}
		
		else {
			echo "email does not exist in the database";
		}
	}
	
	// TODO these 2 functions below need to be in config
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
?>
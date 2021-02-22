<?php
	global $twig;
	require 'config.php';
	$token = $_GET['token'];
	$user = get_user_by_token ($token);
	$expired = compareDate($user);
	$submitted = false;
	
	$webpage = $twig->render('password-reset.html',['token' => $token, 'expired' => $expired]);
	echo $webpage;
	
	function getDateTime() {
		// eastern time
		date_default_timezone_set('America/New_York');
		$date = date('m/d/Y h:i:s a', time());
		
		return $date;
	}
	
	function compareDate($user) {
		$date = $user['token_issued'];
		
		// token expired
		if (strtotime($user['token_issued']) < strtotime('-1 days')) {
			return true;
		}
		
		return false;
	}
		
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
			
			header("Location: index.php");
			exit();
		}
		else {
			// TODO error message
			echo "Passwords don't match. Please try again.";
		}
	}
	
?>


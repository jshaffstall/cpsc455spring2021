<?php

require 'config.php';

$error = null;
if(isset($_POST['email'])){
	$email = $_POST['email'];
	$password = $_POST['password'];
	
	if(login_user($email, $password) != False){
        // This is causing a strange problem on the server
        // with an empty session on future page loads
		//$id = session_regenerate_id(true);
		$_SESSION['user'] = $email;
		header("Location: index.php");
		exit();
	}
	else{
		$error = "Email/Password combination not found";
	}
}

echo $twig->render('login.html',['user' => $user , 'error' => $error]);

?>
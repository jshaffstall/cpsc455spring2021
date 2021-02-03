<?php

require 'config.php';


if(isset($_POST['email'])){
	$email = $_POST['email'];
	$password = $_POST['password'];
	
	if(login_user($email, $password) != False){
		$id = session_regenerate_id(true);
		$_SESSION['user'] = $email;
		header("Location: http://localhost/cpsc455spring2021/webapp/www/index.php");
		exit();
	}
	else{
		print("Email/Password combination not found");
	}
}

echo $twig->render('login.html',['user' => $user]);

?>
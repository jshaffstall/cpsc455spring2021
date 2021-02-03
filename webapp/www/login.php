<?php

require 'config.php';


if(isset($_POST['email'])){
	$email = $_POST['email'];
	$query = $conn->prepare("select password from user where email like '$email'");
	
	$password = $_POST['password'];
	if(login_user($email, $password) != False){
		session_regenerate_id(true);
		header("Location: http://localhost/cpsc455spring2021/webapp/www/index.php");
		exit();
	}
}

echo $twig->render('login.html',[]);

?>
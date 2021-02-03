<?php

require 'config.php';

$server = 'localhost';
$user = 'cpsc455user';
$pass = 'cpsc455spring2021';
$db = 'cpsc455spring2021';

try{
	
	$conn = new PDO("mysql:host=$server;dbname=$db", $user, $pass);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
} catch (PDOException $e) {
		
		print("Error: " + $e->getMessage());
		
	
}



if(isset($_POST['email'])){
	$email = $_POST['email'];
	$query = $conn->prepare("select password from user where email like '$email'");
	
	$password = $_POST['password'];
	if(password_verify($password, $query)){
		session_regenerate_id(true);
		header("Location: http://localhost/cpsc455spring2021/webapp/www/index.php");
		exit();
	}
}

echo $twig->render('login.html',[]);

?>
<html>
<!DOCTYPE html>
<html lang="en">

<head>
<link rel="stylesheet" href="style.css">
<title> Create User </title>
</head>

<header>

<a href="index.php"> Home </a>
<a href="admin-panel.php"> Admin Panel </a>

</header>


<body>

<h1> Create new user </h1>

<?php
	
	require '../includes/db.php';

	$submitted = false;
	
	// TODO: check if valid email and make sure nothing is empty
	if (isset($_POST["role"])) {
		$submitted = true;
	}	
	
	if ($submitted) {	
		submitForm();
	}
	
    displayForm();
	
	function displayForm() {
		$roles = get_roles();
		require '../includes/admin-create-user-template.php';
	}
	
	function submitForm() {
		
		$role = $_POST["role"];
		$name = $_POST["name"];
		$email = $_POST["email"];
		
		add_user($name, $email, $role);
	}
?>

</body>
</html>
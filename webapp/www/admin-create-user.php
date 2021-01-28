<html>
<!DOCTYPE html>
<html lang="en">

<head>
<link rel="stylesheet" href="style.css">
<title> Create User </title>
</head>

	<?php

		
		/*
		Fetch data example
		This gets the emails of all users:
		
		
		$query = $conn->prepare("select email from users");
		$query->execute();
		$result = $query->setFetchMode(PDO::FETCH_ASSOC);
		
		while ($row = $query->fetch()) {
			print("$row[email]"."\n");
		}
		*/

	?>

<header>

<a href="index.php"> Home </a>
<a href="admin-panel.php"> Admin Panel </a>

</header>


<body>

<h1> Create new user </h1>

<?php


	$submitted = false;
	
	$role = $_POST["role"];
	$name = $_POST["name"];
	$email = $_POST["email"];

	// TODO: check if valid email and make sure nothing is empty
	if ($role != null && $name != null && $email != null) {
		$submitted = true;
	}
	
	if ($submitted) {
		submitForm();
	}
    displayForm();
	function displayForm() {
		echo "<div>
				<form action=\"admin-create-user.php\" method=\"post\">
		
				Role <select name=\"role\">
				<option role=\"Student\"> Student </option>
				<option role=\"Field Site\"> Field Site </option>
				<option role=\"Admin\"> Admin </option>
				</select>
				<br>
				
				Name <input type=\"text\" name=\"name\">
				<br>
				
				E-mail <input type=\"text\" name=\"email\">
				<br>
				
				<input type=\"submit\" name=\"user\">
				</form>
				</div>";
	}
	
	function convertRoleToNum($role): int
    {
        // Admin = 1
        // Student = 2
        // Test Site = 3

		if ($role == "Admin") {
			return 1;
		}
		else if ($role == "Student") {
			return 2;
		}
		else if ($role == "Field Site") {
			return 3;
		}
		
		return -1;
	}
	
	function submitForm() {
		// Need these here because previous variables get reset
		$role = $_POST["role"];
		$role = convertRoleToNum($role);
		$name = $_POST["name"];
		$email = $_POST["email"];

		// Connect to database
		$server = "localhost";
		$user = "root";
		$password = "deek";
		$db = "cpsc455spring2021";
		
		try {
			$conn = new PDO("mysql:host=$server;dbname=$db",
			$user, $password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$data = "insert into users (email, name, password, role) values ('$email', '$name', NULL, '$role');";
			$conn->exec($data);

			echo "<p>User was created</p>";
		}
		catch (PDOException $e) {
			print("Connection failed: ".$e->getMessage());
		}
	}
?>

</body>
</html>
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
<p id="errorMessage"></p>

<?php
	require '../includes/db.php';

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
		$roles = get_roles();
		require '../includes/admin-create-user-template.php';
	}
	
	function submitForm() {
		$role = $_POST["role"];
		$name = $_POST["name"];
		$email = $_POST["email"];
		
		// Ensure form is valid
		if (! validForm($role, $name, $email)) {
			return;
		}
		
		else {
			$uniqueEmail = add_user($name, $email, $role);
			
			// Check if user email already exists
			if (! $uniqueEmail) {
				echo '<script type="text/javascript">
				document.getElementById("errorMessage").textContent = "User was not created: A user with that email already exists";
				</script>';
			
				return;
			}
			
		generateAndSetToken($email);
		
		// Report success
		echo '<script type="text/javascript">
			document.getElementById("errorMessage").textContent = "User was successfully created";
			</script>';
		}
	}
	
	function generateAndSetToken($email) {
		$token = uniqid();
		
		// If token already exists, create another
		while (get_user_by_token ($token) != false) {
			$token = uniqid();
		}
		
		set_user_token ($email, $token);
	}
	
	function isEmptyOrWhiteSpace($data) {
		if ($data == '' || ctype_space($data))
			return true;
		
		return false;
	}
	
	function validForm($role, $name, $email) {
		
		// An empty role shouldn't happen, but this is here just in case
		if (isEmptyOrWhiteSpace($role)) {
			echo "$role";
			echo '<script type="text/javascript">
			document.getElementById("errorMessage").textContent = "Please select a role";
			</script>';
			
			return false;
		}
		
		else if (isEmptyOrWhiteSpace($name)) {
			echo '<script type="text/javascript">
			document.getElementById("errorMessage").textContent = "Please fill in the name field";
			</script>';
			
			return false;
		}
		
		else if (isEmptyOrWhiteSpace($email)) {
			echo '<script type="text/javascript">
			document.getElementById("errorMessage").textContent = "Please fill in the email field";
			</script>';
			
			return false;
		}
		
		return true;
	}
?>

</body>
</html>
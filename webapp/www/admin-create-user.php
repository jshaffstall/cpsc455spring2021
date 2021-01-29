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
	
	// TODO: check if valid email and make sure nothing is empty
	if (isset($_POST["role"])) {
		$submitted = true;
	}	
	
	if ($submitted) {	
		submitForm();
	}
	
    displayForm();
	
	function isEmptyOrWhiteSpace($data) {
			if ($data == '' || ctype_space($data))
				return true;
			
			return false;
	}
	
	function displayForm() {
		$roles = get_roles();
		require '../includes/admin-create-user-template.php';
	}
	
	function submitForm() {
		$role = $_POST["role"];
		$name = $_POST["name"];
		$email = $_POST["email"];
		
		// An empty role shouldn't happen
		if (isEmptyOrWhiteSpace($role)) {
			echo "$role";
			echo '<script type="text/javascript">
			document.getElementById("errorMessage").textContent = "Please select a role";
			</script>';
			
			return;
		}
		
		else if (isEmptyOrWhiteSpace($name)) {
			echo '<script type="text/javascript">
			document.getElementById("errorMessage").textContent = "Please fill in the name field";
			</script>';
			
			return;
		}
		
		else if (isEmptyOrWhiteSpace($email)) {
			echo '<script type="text/javascript">
			document.getElementById("errorMessage").textContent = "Please fill in the email field";
			</script>';
			
			return;
		}
		
		else {
			$uniqueEmail = add_user($name, $email, $role);
			
			if (! $uniqueEmail) {
				echo '<script type="text/javascript">
			document.getElementById("errorMessage").textContent = "User was not created: A user with that email already exists";
			</script>';
			return;
			}
			
			echo '<script type="text/javascript">
			document.getElementById("errorMessage").textContent = "User was successfully created";
			</script>';
		}
	}
?>

</body>
</html>
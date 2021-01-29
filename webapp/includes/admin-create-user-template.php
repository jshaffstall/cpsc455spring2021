<div>
<form action="admin-create-user.php" method="post">

Role <select name="role">
<?php
	foreach ($roles as $role) {
		echo '<option value="' . $role['id'] . '"> ' . $role['name'] . '</option>';
	}
?>
</select>
<br>

Name <input type="text" name="name">
<br>

E-mail <input type="text" name="email">
<br>

<input type="submit" name="user">
</form>
</div>
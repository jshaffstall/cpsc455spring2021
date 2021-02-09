<?php

require 'config.php';

	unset($_SESSION['user']);
	header("Location: index.php");
	exit();

?>
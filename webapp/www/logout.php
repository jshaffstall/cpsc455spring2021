<?php

require 'config.php';

	unset($_SESSION['user']);
	header("Location: http://localhost/cpsc455spring2021/webapp/www/index.php");
	exit();

?>
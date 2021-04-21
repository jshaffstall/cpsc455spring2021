<?php

require 'config.php';
if(!($user && $user['role'] == 1))
{
	header("Location:index.php");
	exit();
}
$forms = get_forms();

	echo $twig->render('search.html',['forms' => $forms]);

?>
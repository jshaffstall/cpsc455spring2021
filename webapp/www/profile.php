<?php

require 'config.php';
if(!$user )
{
	header("Location:index.php");
	exit();
}
$types = get_forms_of_type(1);
	
if ($types->rowCount() == 0)
	return False;
$types = $types->fetch(PDO::FETCH_ASSOC);
	
echo $twig->render('profile.html',['types' => $types]);

?>
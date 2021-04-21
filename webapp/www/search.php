<?php

require 'config.php';
if(!($user && $user['role'] == 1))
{
$forms = get_forms();

	echo $twig->render('search.html',['forms' => $forms]);
}
?>
<?php

require 'config.php';

$forms = get_forms();

	echo $twig->render('search.html',['forms' => $forms]);
	
?>
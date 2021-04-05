<?php

require 'config.php';

//searchterms should an array with pairs of key and search words
//create array with POST fieldname and POST search

$searchterms = array(
	array($_POST['fieldname'], $_POST['searchterm'])
);

$search = search_form_submissions($_POST['formid'], $searchterms);

	echo $twig->render('search-searched.html',['formid' => $_POST['formid'],'search' => $search]);
?>

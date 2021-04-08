<?php

require 'config.php';

$forms = [];
$searches = [];

$searchterms = array(
	array($_POST['fieldname'], $_POST['searchterm'])
);

$searches[] = [search_form_submissions($_POST['formid'], $searchterms)];

	foreach($searches as $search){
	
		$form = get_form_by_id($_POST['formid']);
		$searches[] = [$searches, 'name' => $form['name']];
	
	}

	echo $twig->render('search-searched.html',['formid' => $_POST['formid'],'searches' => $searches, 'name' =>$forms]);
?>

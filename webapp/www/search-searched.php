<?php

require 'config.php';

$forms = [];
$submissions = [];
$searches = [];

$searchterms = array(
	$_POST['fieldname'] => $_POST['searchterm']
);
var_dump($searchterms);
$searches = search_form_submissions($_POST['formid'], $searchterms);

if($searches == false){
	echo 'No Results Found';
}
if($searches == true){
	foreach($searches as $search){
	
		$form = get_form_by_id($search['formid']);
		$submissions[] = ['name' => $form['name'], 'id' => $search['id']];
	
	}
}


	echo $twig->render('search-searched.html',['formid' => $_POST['formid'],'searches' => $searches, 'name' =>$forms]);
?>

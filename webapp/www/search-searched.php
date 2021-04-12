<?php

require 'config.php';

$forms = [];
$submissions = [];
$searches = [];

$searchterms = array(
	$_POST['fieldname'] => $_POST['searchterm']
);
$searches = search_form_submissions($_POST['formid'], $searchterms);

if($searches == false){
	echo 'No Results Found';
}
else{
	foreach($searches as $search){
		$form = get_form_by_id($search['formid']);
		$user = get_user_by_id($search['user']);
		$submissions[] = ['name' => $form['name'], 'id' => $search['id'], 'user' => $user['name'], 'email' =>$user['email']];
	
	}
}
	echo $twig->render('search-searched.html',['formid' => $_POST['formid'],'searches' => $submissions, 'name' =>$forms]);
?>

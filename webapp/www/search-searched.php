<?php

require 'config.php';
if(!($user && $user['role'] == 1))
{
	header("Location:index.php");
	exit();
}
$error = null;
$forms = [];
$submissions = [];
$searches = [];
$name = get_form_field_by_name($_POST['formid'], $_POST['fieldname']);
if($name['type'] == 1){
	$searchterms = array(
	$_POST['fieldname'] => $_POST['searchtext']
);
}
if($name['type'] == 2){
	$searchterms = array(
	$_POST['fieldname'] => $_POST['searchcheck']
);
}
if($name['type'] == 3){
	$searchterms = array(
	$_POST['fieldname'] => $_POST['searchdate']
);
}
$searches = search_form_submissions($_POST['formid'], $searchterms);

if($searches == false){
	$error = "No results found";
}
else{
	foreach($searches as $search){
		$form = get_form_by_id($search['formid']);
		$user = get_user_by_id($search['user']);
		$submissions[] = ['name' => $form['name'], 'id' => $search['id'], 'user' => $user['name'], 'email' =>$user['email']];
	
	}
}
	echo $twig->render('search-searched.html',['formid' => $_POST['formid'],'searches' => $submissions, 'name' =>$forms, 'error' => $error]);

?>

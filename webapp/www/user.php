<?php

require 'config.php';

$userid = $_GET['id'];
$user = get_user_by_id ($userid);
echo $twig->render('user.html', ['user' => $user]);

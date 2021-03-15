<?php

require 'config.php';

$email = $_GET['email'];
$user = get_user($email);
echo $twig->render('user.html', ['user' => $user]);

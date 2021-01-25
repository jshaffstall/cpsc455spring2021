<?php

// This is an example showing how to use the db functions

require '../includes/db.php';

$roles = get_roles();

foreach ($roles as $row)
{
    echo $row['name'].'<br>';
}    

if (login_user('admin@muskingum.edu', 'password'))
    echo 'Logged in with password<br>';
else
    echo 'Could not login with password<br>';
    
if (login_user('admin@muskingum.edu', 'notthepassword'))
    echo 'Logged in with notthepassword<br>';
else
    echo 'Could not login with notthepassword<br>';


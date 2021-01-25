<?php

// This is an example showing how to use the db functions

require '../includes/db.php';

$roles = get_roles();

foreach ($roles as $row)
{
    echo $row['name'].'<br>';
}    



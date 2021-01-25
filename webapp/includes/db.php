<?php

require 'db_config.php';

function get_roles()
{
    global $pdo;
    
    $sql = "SELECT * FROM Roles ORDER BY name";
    $stmt = $pdo->prepare($sql);
    $stmt->execute ();

    return $stmt;
}

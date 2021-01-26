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

function add_user($name, $email, $password)
{
    global $pdo;
    
    $sql = "INSERT INTO Users (name, email, password) VALUES (:name, :email, :password)";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':name', $name);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':password',  password_hash ($password, PASSWORD_BCRYPT));
    
    $stmt->execute();
}

function login_user ($email, $password)
{
    global $pdo;

    $sql = "SELECT * FROM Users where email=:email";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':email', $email);
    
    $stmt->execute();
    
    if ($stmt->rowCount() == 0)
        return False;
    
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (password_verify ($password, $user['password']))
        return $user;
    
    return False;
}

function get_user ($email)
{
    global $pdo;

    $sql = "SELECT * FROM Users where email=:email";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':email', $email);
    
    $stmt->execute();
    
    if ($stmt->rowCount() == 0)
        return False;
    
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    return $user;
}

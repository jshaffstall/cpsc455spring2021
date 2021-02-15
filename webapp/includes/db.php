<?php

require 'db_config.php';

function get_roles()
{
    global $pdo;
    
    $sql = "SELECT * FROM roles ORDER BY name";
    $stmt = $pdo->prepare($sql);
    $stmt->execute ();

    return $stmt;
}

function add_user($name, $email, $role)
{
    global $pdo;
    
    if (get_user($email))
        return False;
    
    $sql = "INSERT INTO users (name, email, role) VALUES (:name, :email, :role)";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':name', $name);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':role',  $role);
    
    $stmt->execute();
    
    return True;
}

function login_user ($email, $password)
{
    global $pdo;

    $sql = "SELECT * FROM users where email=:email";
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

    $sql = "SELECT * FROM users where email=:email";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':email', $email);
    
    $stmt->execute();
    
    if ($stmt->rowCount() == 0)
        return False;
    
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    return $user;
}

function get_user_by_token ($token)
{
    global $pdo;

    $sql = "SELECT * FROM users where token=:token";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':token', $token);
    
    $stmt->execute();
    
    if ($stmt->rowCount() == 0)
        return False;
    
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    return $user;
}

function set_user_token ($email, $token)
{
    global $pdo;

    $sql = "UPDATE users SET token=:token, token_issued=NOW() WHERE email=:email";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':token', $token);
    
    $stmt->execute();
}

function clear_user_token ($email)
{
    global $pdo;

    $sql = "UPDATE users SET token=NULL, token_issued=NULL WHERE email=:email";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':email', $email);
    
    $stmt->execute();
}

function set_user_password ($email, $password)
{
    global $pdo;

    $sql = "UPDATE users SET password=:password WHERE email=:email";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':password', password_hash ($password, PASSWORD_BCRYPT));
    
    $stmt->execute();
}

function get_form_field_types()
{
    global $pdo;
    
    $sql = "SELECT * FROM formfieldtypes ORDER BY name";
    $stmt = $pdo->prepare($sql);
    $stmt->execute ();

    return $stmt;
}

function get_forms()
{
    global $pdo;
    
    $sql = "SELECT * FROM forms ORDER BY name";
    $stmt = $pdo->prepare($sql);
    $stmt->execute ();

    return $stmt;
}

function get_form($name)
{
    global $pdo;
	
    $sql = "SELECT * FROM forms where name=:name";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':name', $name);
    
    $stmt->execute();
    
    if ($stmt->rowCount() == 0)
        return False;
	
	return $stmt->fetch(PDO::FETCH_ASSOC);
}

function add_form ($name)
{
    global $pdo;

	// Returns False if the name is already used by another form
	// Returns the form object if creation is successful
	
    $sql = "SELECT * FROM forms where name=:name";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':name', $name);
    
    $stmt->execute();
    
    if ($stmt->rowCount() > 0)
        return False;

    $sql = "INSERT INTO forms (name) VALUES (:name)";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':name', $name);
    $stmt->execute();
	
	return get_form($name);
}

function get_form_fields($form)
{
    global $pdo;

    $sql = "SELECT formfields.id, formfields.form, formfields.label, formfields.type, formfields.default, formfields.order, formfieldtypes.name FROM formfields, formfieldtypes WHERE formfields.form=:form and formfields.type=formfieldtypes.id ORDER BY `order`";
    
	//$sql = "SELECT * FROM formfields WHERE form=:form ORDER BY `order`";
	
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':form', $form);
    
    $stmt->execute();
	
    return $stmt;
}

function get_form_field($formfield)
{
    global $pdo;

    $sql = "SELECT formfields.id, formfields.form, formfields.label, formfields.type, formfields.default, formfields.order, formfieldtypes.name FROM formfields, formfieldtypes WHERE formfields.id=:formfield and formfields.type=formfieldtypes.id";
    
	//$sql = "SELECT * FROM formfields WHERE form=:form ORDER BY `order`";
	
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':formfield', $formfield);
    
    $stmt->execute();
	
    if ($stmt->rowCount() == 0)
        return False;
	
	return $stmt->fetch(PDO::FETCH_ASSOC);
}

function add_form_field ($form, $type, $label, $default, $order)
{
    global $pdo;

    $sql = "INSERT INTO formfields (form, type, label, `default`, `order`) VALUES (:form, :type, :label, :default, :order)";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':form', $form);
    $stmt->bindValue(':type', $type);
    $stmt->bindValue(':label', $label);
    $stmt->bindValue(':default', $default);
    $stmt->bindValue(':order', $order);
    
    $stmt->execute();
}

function delete_form_field($formfield)
{
	global $pdo;
	
    $sql = "DELETE FROM formfields where id=:id";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':id', $formfield);
    
    $stmt->execute();
}

function update_form_field($formfield, $type, $label, $default, $order)
{
    global $pdo;

    $sql = "UPDATE formfields SET type=:type, label=:label, `default`=:default, `order`=:order WHERE id=:formfield";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':formfield', $formfield);
    $stmt->bindValue(':type', $type);
    $stmt->bindValue(':label', $label);
    $stmt->bindValue(':default', $default);
    $stmt->bindValue(':order', $order);
    
    $stmt->execute();
}

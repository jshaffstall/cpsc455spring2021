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
    
    if ($user['disabled'])
        return False;
    
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

function get_users($disabled = false)
{
    global $pdo;
    
    $sql = "SELECT * FROM users WHERE disabled=:disabled ORDER BY name";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':disabled', $disabled);
    
    $stmt->execute ();

    return $stmt;
}

function disable_user($id)
{
    global $pdo;
    
    $sql = "UPDATE users SET disabled=1 WHERE id=:id";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':id', $id);
    
    $stmt->execute ();

    return $stmt;
}

function enable_user($id)
{
    global $pdo;
    
    $sql = "UPDATE users SET disabled=0 WHERE id=:id";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':id', $id);
    
    $stmt->execute ();

    return $stmt;
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

    $sql = "SELECT formfields.id, formfields.form, formfields.label, formfields.type, formfields.default, formfields.order, formfieldtypes.name, formfields.fieldname, formfields.eol, formfields.size FROM formfields, formfieldtypes WHERE formfields.form=:form and formfields.type=formfieldtypes.id ORDER BY `order`";
    
	//$sql = "SELECT * FROM formfields WHERE form=:form ORDER BY `order`";
	
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':form', $form);
    
    $stmt->execute();
	
    return $stmt;
}

function get_form_field($formfield)
{
    global $pdo;

    $sql = "SELECT formfields.id, formfields.form, formfields.label, formfields.type, formfields.default, formfields.order, formfieldtypes.name, formfields.fieldname, formfields.eol, formfields.size FROM formfields, formfieldtypes WHERE formfields.id=:formfield and formfields.type=formfieldtypes.id";
    
	//$sql = "SELECT * FROM formfields WHERE form=:form ORDER BY `order`";
	
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':formfield', $formfield);
    
    $stmt->execute();
	
    if ($stmt->rowCount() == 0)
        return False;
	
	return $stmt->fetch(PDO::FETCH_ASSOC);
}

function add_form_field ($form, $type, $label, $default, $order, $name, $eol=True, $size=20)
{
    global $pdo;

	$sql = "SELECT * FROM formfields where form=:form and fieldname=:name";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':form', $form);
    $stmt->bindValue(':name', $name);
	
	$stmt->execute();
	
    if ($stmt->rowCount() > 0)
        return False;	
	
    $sql = "INSERT INTO formfields (form, type, label, `default`, `order`, fieldname, eol, size) VALUES (:form, :type, :label, :default, :order, :name, :eol, :size)";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':form', $form);
    $stmt->bindValue(':type', $type);
    $stmt->bindValue(':label', $label);
    $stmt->bindValue(':default', $default);
    $stmt->bindValue(':order', $order);
    $stmt->bindValue(':name', $name);
    $stmt->bindValue(':eol', $eol);
    $stmt->bindValue(':size', $size);
    
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

function update_form_field($form, $formfield, $type, $label, $default, $order, $name, $eol=True, $size=20)
{
    global $pdo;

	$sql = "SELECT * FROM formfields where form=:form and fieldname=:name and id!=:formfield";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':form', $form);
    $stmt->bindValue(':name', $name);
    $stmt->bindValue(':formfield', $formfield);
	
	$stmt->execute();
	
    if ($stmt->rowCount() > 0)
        return False;	

    $sql = "UPDATE formfields SET type=:type, label=:label, `default`=:default, `order`=:order, fieldname=:name, eol=:eol, size=:size WHERE id=:formfield";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':formfield', $formfield);
    $stmt->bindValue(':type', $type);
    $stmt->bindValue(':label', $label);
    $stmt->bindValue(':default', $default);
    $stmt->bindValue(':order', $order);
    $stmt->bindValue(':name', $name);
    $stmt->bindValue(':eol', $eol);
    $stmt->bindValue(':size', $size);
    
    $stmt->execute();
}

function get_form_types()
{
    global $pdo;
    
    $sql = "SELECT * FROM formtypes ORDER BY name";
    $stmt = $pdo->prepare($sql);
    
    $stmt->execute ();

    return $stmt;
}

function add_form_type($name)
{
    global $pdo;
    
    $sql = "SELECT * FROM formtypes WHERE name=:name";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':name', $name);
    
    $stmt->execute ();

    if ($stmt->rowCount() > 0)
        return False;	

    $sql = "INSERT INTO formtypes (name) VALUES (:name)";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':name', $name);
    
    $stmt->execute ();

    return True;
}

function get_forms_of_type($type_id)
{
    global $pdo;
    
    $sql = "SELECT * FROM forms, formtypemappings WHERE forms.id=formtypemappings.formid and formtypemappings.typeid=:type_id ORDER BY name";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':type_id', $type_id);
    
    $stmt->execute ();

    return $stmt;
}

function add_form_of_type($form_id, $type_id)
{
    global $pdo;
    
	$sql = "SELECT * FROM formtypemappings WHERE formid=:form_id and typeid=:type_id";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':form_id', $form_id);
    $stmt->bindValue(':type_id', $type_id);
	
	$stmt->execute();
	
    if ($stmt->rowCount() > 0)
        return False;	
    
    $sql = "INSERT INTO formtypemappings (formid, typeid) VALUES (:form_id, :type_id)";
    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(':form_id', $form_id);
    $stmt->bindValue(':type_id', $type_id);

    $stmt->execute ();
    
    return True;
}

function remove_form_of_type($form_id, $type_id)
{
    global $pdo;
    
    $sql = "DELETE FROM formtypemappings WHERE formid=:form_id and typeid=:type_id";
    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(':form_id', $form_id);
    $stmt->bindValue(':type_id', $type_id);

    $stmt->execute ();
}

function submit_form($user, $formid, $values)
{
	// How to know if we're editing a form or submitting a new version of it?
	
	// For now assume all forms are edited if they were already submitted
	
	// Find an existing submission if one exists, otherwise insert a new formsubmissions row
	// if we found an existing submission, delete all the field submissions for that form submission
	
	// for each value in values
	// 		look up that form field by form id and fieldname to get the type
	//      insert a new field submission for that value
}

function get_all_form_submissions ()
{
	// return all form submissions
}

function get_form_submissions ($user)
{
	// return all form submissions for this user
}

function get_form_submission($user, formid)
{
	// Get the particular form submission
}

function get_field_submissions($formsubmissionid)
{
	// Return all the field submissions for the given form submission
}

function search_form_submissions ($searchterms)
{
	// searchterms is an associative array with the key being the field name and the value being the search value for that field
	// Need to allow searching based on the value of specific fields
	// Allow partial searching for text fields?
	
	// Return a list of matching form submissions
}

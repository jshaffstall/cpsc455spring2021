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

function get_user_by_id ($userid)
{
    global $pdo;

    $sql = "SELECT * FROM users where id=:userid";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':userid', $userid);
    
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

function get_users_by_role($roleid, $disabled = false)
{
    global $pdo;
    
    $sql = "SELECT * FROM users WHERE role=:roleid and disabled=:disabled ORDER BY name";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':roleid', $roleid);
    $stmt->bindValue(':disabled', $disabled);
    
    $stmt->execute ();

    return $stmt;
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

function get_forms($namefilter='', $archived=0)
{
    global $pdo;
    
    $sql = "SELECT * FROM forms WHERE name LIKE :namefilter AND archived=:archived ORDER BY name";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':namefilter', "%".$namefilter."%");
    $stmt->bindValue(':archived', $archived);
    
    $stmt->execute ();

    return $stmt;
}

function get_archived_forms($namefilter='')
{
    return get_forms($namefilter, 1);
}

function get_student_forms()
{
    global $pdo;
    
    $sql = "SELECT * FROM forms WHERE roleid=2 AND archived=0 ORDER BY name";
    $stmt = $pdo->prepare($sql);
    $stmt->execute ();

    return $stmt;
}

function get_admin_forms()
{
    global $pdo;
    
    $sql = "SELECT * FROM forms WHERE roleid=1 AND archived=0 ORDER BY name";
    $stmt = $pdo->prepare($sql);
    $stmt->execute ();

    return $stmt;
}

function get_student_forms_for_site()
{
    global $pdo;
    
    $sql = "SELECT * FROM forms WHERE roleid=2 AND archived=0 AND sitevisible=1 ORDER BY name";
    $stmt = $pdo->prepare($sql);
    $stmt->execute ();

    return $stmt;
}

function get_site_forms()
{
    global $pdo;
    
    $sql = "SELECT * FROM forms WHERE roleid=3 AND student=0 AND archived=0 ORDER BY name";
    $stmt = $pdo->prepare($sql);
    $stmt->execute ();

    return $stmt;
}

function get_site_forms_for_students($siteid)
{
    global $pdo;
    
    $sql = "SELECT * FROM forms WHERE roleid=3 AND student=1 AND archived=0 AND (siteid=:siteid OR siteid IS NULL) ORDER BY name";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':siteid', $siteid);
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

function get_form_by_id($formid)
{
    global $pdo;
	
    $sql = "SELECT * FROM forms where id=:formid";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':formid', $formid);
    
    $stmt->execute();
    
    if ($stmt->rowCount() == 0)
        return False;
	
	return $stmt->fetch(PDO::FETCH_ASSOC);
}

function add_form($name, $roleid, $forstudent, $sitevisible=false, $siteid=null)
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

    $sql = "INSERT INTO forms (name, roleid, student, sitevisible, siteid) VALUES (:name, :roleid, :forstudent, :sitevisible, :siteid)";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':name', $name);
    $stmt->bindValue(':roleid', $roleid);
    $stmt->bindValue(':forstudent', $forstudent);
    $stmt->bindValue(':sitevisible', $sitevisible);
    $stmt->bindValue(':siteid', $siteid);
    
    $stmt->execute();
	
	return get_form($name);
}

function get_form_fields($form)
{
    global $pdo;

    $sql = "SELECT formfields.id, formfields.form, formfields.label, formfields.type, formfields.order, formfieldtypes.name, formfields.fieldname, formfields.eol, formfields.size, formfields.required FROM formfields, formfieldtypes WHERE formfields.form=:form and formfields.type=formfieldtypes.id ORDER BY `order`";
    
	//$sql = "SELECT * FROM formfields WHERE form=:form ORDER BY `order`";
	
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':form', $form);
    
    $stmt->execute();
	
    return $stmt;
}

function get_form_field($formfield)
{
    global $pdo;

    $sql = "SELECT formfields.id, formfields.form, formfields.label, formfields.type, formfields.order, formfieldtypes.name, formfields.fieldname, formfields.eol, formfields.size, formfields.required FROM formfields, formfieldtypes WHERE formfields.id=:formfield and formfields.type=formfieldtypes.id";
    
	//$sql = "SELECT * FROM formfields WHERE form=:form ORDER BY `order`";
	
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':formfield', $formfield);
    
    $stmt->execute();
	
    if ($stmt->rowCount() == 0)
        return False;
	
	return $stmt->fetch(PDO::FETCH_ASSOC);
}

function get_form_field_by_name($formid, $name)
{
    global $pdo;

    $sql = "SELECT formfields.id, formfields.form, formfields.label, formfields.type, formfields.order, formfieldtypes.name, formfields.fieldname, formfields.eol, formfields.size, formfields.required FROM formfields, formfieldtypes WHERE formfields.form=:formid and formfields.fieldname=:name";
    
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':formid', $formid);
    $stmt->bindValue(':name', $name);
    
    $stmt->execute();
	
    if ($stmt->rowCount() == 0)
        return False;
	
	return $stmt->fetch(PDO::FETCH_ASSOC);
}

function get_form_field_by_order($formid, $order)
{
    global $pdo;

    $sql = "SELECT formfields.id, formfields.form, formfields.label, formfields.type, formfields.order, formfieldtypes.name, formfields.fieldname, formfields.eol, formfields.size, formfields.required FROM formfields, formfieldtypes WHERE formfields.form=:formid and formfields.order=:order";
    
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':formid', $formid);
    $stmt->bindValue(':order', $order);
    
    $stmt->execute();
	
    if ($stmt->rowCount() == 0)
        return False;
	
	return $stmt->fetch(PDO::FETCH_ASSOC);
}

function add_form_field ($form, $type, $label, $name, $eol=True, $size=20, $required=0)
{
    global $pdo;

	$sql = "SELECT * FROM formfields where form=:form and fieldname=:name";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':form', $form);
    $stmt->bindValue(':name', $name);
	
	$stmt->execute();
	
    if ($stmt->rowCount() > 0)
        return False;	
	
	if (empty($size))
		$size = 20;
	
    $sql = "INSERT INTO formfields (form, type, label, `order`, fieldname, eol, size, required) VALUES (:form, :type, :label, COALESCE((SELECT MAX( `order` )+1 FROM formfields ff WHERE ff.form=:form), 1), :name, :eol, :size, :required)";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':form', $form);
    $stmt->bindValue(':type', $type);
    $stmt->bindValue(':label', $label);
    $stmt->bindValue(':name', $name);
    $stmt->bindValue(':eol', $eol);
    $stmt->bindValue(':size', $size);
    $stmt->bindValue(':required', $required);
    
    $stmt->execute();
    return True;
}

function delete_form_field($formfield)
{
	global $pdo;
	
	$field = get_form_field($formfield);
	
	if (! $field)
		return;
	
    $sql = "DELETE FROM formfields where id=:id";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':id', $formfield);
    
    $stmt->execute();
	
	$sql = "UPDATE formfields SET `order` = `order` - 1 WHERE `order` > :order and form = :form";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':order', $field['order']);
    $stmt->bindValue(':form', $field['form']);
    
    $stmt->execute();
	
}

function update_form($form, $name, $roleid, $forstudent, $sitevisible=false, $siteid=null)
{
    global $pdo;

	$sql = "SELECT * FROM forms where id!=:form and name=:name";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':form', $form);
    $stmt->bindValue(':name', $name);
	
	$stmt->execute();
	
    if ($stmt->rowCount() > 0)
        return False;	

    $sql = "UPDATE forms SET name=:name, roleid=:roleid, student=:forstudent, sitevisible=:sitevisible, siteid=:siteid WHERE id=:form";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':form', $form);
    $stmt->bindValue(':name', $name);
    $stmt->bindValue(':roleid', $roleid);
    $stmt->bindValue(':forstudent', $forstudent);
    $stmt->bindValue(':sitevisible', $sitevisible);
    $stmt->bindValue(':siteid', $siteid);
    
    $stmt->execute();
    return True;
}

function update_form_field($form, $formfield, $type, $label, $order, $name, $eol=True, $size=20, $required=0)
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

    $sql = "UPDATE formfields SET type=:type, label=:label, `order`=:order, fieldname=:name, eol=:eol, size=:size, required=:required WHERE id=:formfield";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':formfield', $formfield);
    $stmt->bindValue(':type', $type);
    $stmt->bindValue(':label', $label);
    $stmt->bindValue(':order', $order);
    $stmt->bindValue(':name', $name);
    $stmt->bindValue(':eol', $eol);
    $stmt->bindValue(':size', $size);
    $stmt->bindValue(':required', $required);
    
    $stmt->execute();
    return True;
}

function update_form_field_order($formfield, $order)
{
    global $pdo;

    $sql = "UPDATE formfields SET `order`=:order WHERE id=:formfield";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':formfield', $formfield);
    $stmt->bindValue(':order', $order);
    
    $stmt->execute();
}

function submit_form($user, $formid, $values, $siteid=null)
{
    global $pdo;
    
    $submission = get_form_submission($user, $formid, $siteid);

    return process_form_submission ($user, $formid, $values, $siteid, $submission);
}

function submit_form_for_site($user, $formid, $values, $siteid)
{
    global $pdo;
    
    $submission = get_form_submission_for_site($formid, $siteid);
    
    return process_form_submission ($user, $formid, $values, $siteid, $submission);
}

function submit_form_as_admin($user, $formid, $values, $submission, $siteid=null)
{
    global $pdo;
    
    $submission = get_form_submission_by_id($submission);
    
    return process_form_submission ($submission['user'], $formid, $values, $siteid, $submission);
}

function submit_admin_form($user, $formid, $values)
{
    global $pdo;
    
    $submission = get_admin_form_submission($formid);
    
    return process_form_submission ($user, $formid, $values, null, $submission);
}

function process_form_submission($user, $formid, $values, $siteid, $submission)
{
    global $pdo;
    
    $pdo->beginTransaction();
    
    $errors = [];
    
    if ($submission)
    {
        // Update the submission date for the new submission
        $sql = "UPDATE formsubmissions SET `when`=NOW(), user=:user WHERE id=:id";
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindValue(':id', $submission['id']);
        $stmt->bindValue(':user', $user);
        
        $stmt->execute();
        
        // delete all existing field submissions for this form submission
        $sql = "DELETE FROM fieldsubmissions WHERE formsubmissionid=:formsubmissionid";
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindValue(':formsubmissionid', $submission['id']);
        
        $stmt->execute();
    }
    else
    {
        // insert a new form submission
        $sql = "INSERT INTO formsubmissions (formid, user, siteid) VALUES (:formid, :user, :siteid)";
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindValue(':formid', $formid);
        $stmt->bindValue(':user', $user);
        $stmt->bindValue(':siteid', $siteid, PDO::PARAM_INT);
        
        $stmt->execute();
        
        $submission = get_form_submission($user, $formid, $siteid);
        
        if (! $submission)
        {
            // Something went very wrong!
            $pdo->rollback();
            $errors[] = "Unable to fetch newly inserted submission";
            return $errors;
        }
    }

    foreach ($values as $name => $value)
    {
        $formfield = get_form_field_by_name($formid, $name);
        
        if (! $formfield)
        {
            // Skip this one, it's probably extra info that isn't in the form
			continue;
        }
        
        $file_contents = null;
        $content_type = null;
		$size = null;
		
        if ($formfield['type'] == 4)
        {
            if ($value == "1")
                $value = null;
        
            // File upload, need to pull info from the $_FILES array
            // It's possible the user did not select a file.
            if (array_key_exists($formfield['fieldname'], $_FILES))
            {
                if (is_uploaded_file($_FILES[$formfield['fieldname']]['tmp_name']))
                {
                    $value = $_FILES[$formfield['fieldname']]['name'];
                    
                    $file_contents = file_get_contents($_FILES[$formfield['fieldname']]['tmp_name']);
                    
                    $finfo = finfo_open(FILEINFO_MIME_TYPE);
                    $content_type = finfo_file($finfo, $_FILES[$formfield['fieldname']]['tmp_name']);
                    finfo_close($finfo);
                    
                    $size = filesize($_FILES[$formfield['fieldname']]['tmp_name']);
                }
                else
                {
					if ($formfield['required'])
						$errors[] = "Field '".$formfield['label']."' is required";
                }
            }
            else
            {
				if ($formfield['required'])
					$errors[] = "Field '".$formfield['label']."' is required";
            }
        }
        else
        {
            if ($formfield['type'] == 1 || $formfield['type'] == 3)
                if (empty($value) and $formfield['required'])
                    $errors[] = "Field '".$formfield['label']."' is required";
        }
        
        $sql = "INSERT INTO fieldsubmissions (formsubmissionid, value, type, name, file, content_type, size) VALUES (:formsubmissionid, :value, :type, :name, :file_contents, :content_type, :size)";
        
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindValue(':formsubmissionid', $submission['id']);
        $stmt->bindValue(':value', $value);
        $stmt->bindValue(':type', $formfield['type']);
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':file_contents', $file_contents);
        $stmt->bindValue(':content_type', $content_type);
		$stmt->bindValue(':size', $size);
        
        $stmt->execute();
    }
    
    if (empty($errors))
    {
        $pdo->commit();
        return False;
    }
    
    $pdo->rollback();
    return $errors;
}

function get_all_form_submissions ()
{
    global $pdo;

    $sql = "SELECT formsubmissions.*, forms.name, forms.roleid, forms.student, users.name as username, users.email FROM formsubmissions INNER JOIN users ON formsubmissions.user = users.id INNER JOIN forms ON formsubmissions.formid = forms.id WHERE forms.archived=0 AND users.disabled = 0 ORDER BY `when` DESC";
    
    $stmt = $pdo->prepare($sql);
    
    $stmt->execute();
	
    if ($stmt->rowCount() == 0)
        return False;
	
	return $stmt;
}

function get_form_submissions ($user)
{
    global $pdo;

    $sql = "SELECT formsubmissions.*, forms.name, forms.roleid, forms.student, users.name as username, users.email FROM formsubmissions INNER JOIN users ON formsubmissions.user = users.id INNER JOIN forms ON formsubmissions.formid = forms.id WHERE user=:user AND forms.archived=0 AND users.disabled = 0 ORDER BY `when` DESC";

    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':user', $user);
    
    $stmt->execute();
	
	return $stmt;
}

function get_form_submissions_visible_to_sites ($user)
{
    global $pdo;

    $sql = "SELECT formsubmissions.*, forms.name, forms.roleid, forms.student FROM formsubmissions,forms WHERE user=:user AND formid=forms.id AND forms.archived=0 AND sitevisible=1 ORDER BY `when` DESC";
    
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':user', $user);
    
    $stmt->execute();
	
	return $stmt;
}

function get_student_form_submissions_for_site ($user, $site)
{
    global $pdo;

    $sql = "SELECT formsubmissions.*, forms.name, forms.roleid, forms.student FROM formsubmissions,forms WHERE user=:user AND formid=forms.id AND forms.archived=0 AND formsubmissions.siteid=:site AND roleid=3 AND student=1 ORDER BY `when` DESC";
    
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':user', $user);
    $stmt->bindValue(':site', $site);
    
    $stmt->execute();
	
	return $stmt;
}

function get_form_submission($user, $formid, $siteid=null)
{
    global $pdo;

    if (is_null($siteid))
        $sql = "SELECT * FROM formsubmissions WHERE formid=:formid and user=:user and siteid IS NULL";
    else
        $sql = "SELECT * FROM formsubmissions WHERE formid=:formid and user=:user and siteid=:siteid";
    
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':formid', $formid);
    $stmt->bindValue(':user', $user);
    
    if (! is_null($siteid))
        $stmt->bindValue(':siteid', $siteid);
    
    $stmt->execute();
	
    if ($stmt->rowCount() == 0)
        return False;
	
	return $stmt->fetch(PDO::FETCH_ASSOC);
}

function get_form_submission_for_site($formid, $siteid)
{
    global $pdo;

    $sql = "SELECT * FROM formsubmissions WHERE formid=:formid and siteid=:siteid";
    
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':formid', $formid);
    $stmt->bindValue(':siteid', $siteid);
    
    $stmt->execute();
	
    if ($stmt->rowCount() == 0)
        return False;
	
	return $stmt->fetch(PDO::FETCH_ASSOC);
}

function get_admin_form_submission($formid)
{
    global $pdo;

    $sql = "SELECT * FROM formsubmissions WHERE formid=:formid";
    
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':formid', $formid);
    
    $stmt->execute();
	
    if ($stmt->rowCount() == 0)
        return False;
	
	return $stmt->fetch(PDO::FETCH_ASSOC);
}

function get_form_submission_by_id($submissionid)
{
    global $pdo;

    $sql = "SELECT * FROM formsubmissions WHERE id=:submissionid";
    
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':submissionid', $submissionid);
    
    $stmt->execute();
	
    if ($stmt->rowCount() == 0)
        return False;
	
	return $stmt->fetch(PDO::FETCH_ASSOC);
}


function get_field_submissions($formsubmissionid)
{
    global $pdo;

    $sql = "SELECT * FROM fieldsubmissions WHERE formsubmissionid=:formsubmissionid";
    
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':formsubmissionid', $formsubmissionid);
    
    $stmt->execute();
	
	return $stmt;
}

function get_field_submission($fieldsubmissionid)
{
    global $pdo;

    $sql = "SELECT * FROM fieldsubmissions WHERE id=:id";
    
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':id', $fieldsubmissionid);
    
    $stmt->execute();
	
    if ($stmt->rowCount() == 0)
        return False;
	
	return $stmt->fetch(PDO::FETCH_ASSOC);
}

function search_form_submissions ($formid, $searchterms)
{
    global $pdo;

	$sql = "SELECT DISTINCT formsubmissions.* FROM formsubmissions INNER JOIN users ON formsubmissions.user = users.id INNER JOIN forms ON formsubmissions.formid = forms.id INNER JOIN fieldsubmissions ON formsubmissions.id = fieldsubmissions.formsubmissionid WHERE forms.archived=0 AND users.disabled = 0 AND formsubmissions.formid=:formid ";
	$searches = "";
	
	foreach ($searchterms as $name => $value)
	{
        $formfield = get_form_field_by_name($formid, $name);
        
        if (! $formfield)
        {
            // Something went very wrong!
            return False;
        }
		
		if ($formfield['type'] == 1)
		{
			// Edit field, allow partial searches
			$searches = " AND fieldsubmissions.name=:".$name." AND fieldsubmissions.value LIKE :".$name."_value ";
            $searchterms[$name] = "%".$value."%";
		}
		
		if ($formfield['type'] == 2)
		{
			// Checkbox, exact searches only
			$searches = " AND fieldsubmissions.name=:".$name." AND fieldsubmissions.value=:".$name."_value ";
		}
        
		if ($formfield['type'] == 3)
		{
			// Date, exact searches only
			$searches = " AND fieldsubmissions.name=:".$name." AND fieldsubmissions.value=:".$name."_value ";
		}
 	}
	
	$sql .= $searches;
	
    $stmt = $pdo->prepare($sql);
	
	$stmt->bindValue(':formid', $formid);
    
	foreach ($searchterms as $name => $value)
	{
		$stmt->bindValue(':'.$name, $name);
		$stmt->bindValue(':'.$name."_value", $value);
	}
    
    $stmt->execute();

    if ($stmt->rowCount() == 0)
        return False;
	
	return $stmt;
}

function add_site ($name)
{
    global $pdo;

	// Returns False if the name is already used by another site
	// Returns the site object if creation is successful
	
    $sql = "SELECT * FROM fieldworksites where name=:name";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':name', $name);
    
    $stmt->execute();
    
    if ($stmt->rowCount() > 0)
        return False;

    $sql = "INSERT INTO fieldworksites (name) VALUES (:name)";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':name', $name);
    
    $stmt->execute();
	
	return get_site($name);
}

function get_site($name)
{
    global $pdo;
	
    $sql = "SELECT * FROM fieldworksites where name=:name";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':name', $name);
    
    $stmt->execute();
    
    if ($stmt->rowCount() == 0)
        return False;
	
	return $stmt->fetch(PDO::FETCH_ASSOC);
}

function get_site_by_id($siteid)
{
    global $pdo;
	
    $sql = "SELECT * FROM fieldworksites where id=:siteid";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':siteid', $siteid);
    
    $stmt->execute();
    
    if ($stmt->rowCount() == 0)
        return False;
	
	return $stmt->fetch(PDO::FETCH_ASSOC);
}

function get_sites()
{
    global $pdo;
	
    $sql = "SELECT * FROM fieldworksites ORDER BY name";
    $stmt = $pdo->prepare($sql);
    
    $stmt->execute();
    
    if ($stmt->rowCount() == 0)
        return False;
	
	return $stmt;
}

function update_site($site, $name)
{
    global $pdo;

	$sql = "SELECT * FROM fieldworksites where id!=:site and name=:name";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':site', $site);
    $stmt->bindValue(':name', $name);
	
	$stmt->execute();
	
    if ($stmt->rowCount() > 0)
        return False;	

    $sql = "UPDATE fieldworksites SET name=:name WHERE id=:site";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':site', $site);
    $stmt->bindValue(':name', $name);
    
    $stmt->execute();
    return True;
}

function remove_site($site)
{
    global $pdo;

    $sql = "DELETE FROM fieldworksites WHERE id=:site";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':site', $site);
    
    $stmt->execute();
}

function assign_user_to_site ($userid, $siteid)
{
    global $pdo;

	// Returns False if the user is already assigned to the site
	// Returns True if creation is successful
	
    $sql = "SELECT * FROM usersitemappings WHERE userid=:userid AND siteid=:siteid";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':userid', $userid);
    $stmt->bindValue(':siteid', $siteid);
    
    $stmt->execute();
    
    if ($stmt->rowCount() > 0)
        return False;

    $sql = "INSERT INTO usersitemappings (userid, siteid) VALUES (:userid, :siteid)";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':userid', $userid);
    $stmt->bindValue(':siteid', $siteid);
    
    $stmt->execute();
	
	return True;
}

function remove_user_from_site($userid, $siteid)
{
    global $pdo;

    $sql = "DELETE FROM usersitemappings WHERE userid=:userid AND siteid=:siteid";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':userid', $userid);
    $stmt->bindValue(':siteid', $siteid);
    
    $stmt->execute();
}

function get_users_for_site($siteid, $roleid)
{
    global $pdo;
	
    $sql = "SELECT * FROM usersitemappings, users WHERE siteid=:siteid AND userid=users.id AND users.role=:roleid";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':roleid', $roleid);
    $stmt->bindValue(':siteid', $siteid);
    
    $stmt->execute();
    
	return $stmt;
}

function get_sites_for_user($userid)
{
    global $pdo;
	
    $sql = "SELECT * FROM usersitemappings,fieldworksites WHERE userid=:userid AND siteid=fieldworksites.id";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':userid', $userid);
    
    $stmt->execute();
    
    if ($stmt->rowCount() == 0)
        return False;
	
	return $stmt;
}

function archive_form($formid)
{
    global $pdo;
    
    $sql = "UPDATE forms SET archived=1 WHERE id=:formid";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':formid', $formid);
    
    $stmt->execute ();

    return $stmt;
}

function unarchive_form($formid)
{
    global $pdo;
    
    $sql = "UPDATE forms SET archived=0 WHERE id=:formid";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':formid', $formid);
    
    $stmt->execute ();

    return $stmt;
}

function delete_user($userid)
{
    global $pdo;
    
    // start transaction
    $pdo->beginTransaction();
    
    // delete field submissions for that user
    $sql = "DELETE fieldsubmissions FROM fieldsubmissions INNER JOIN formsubmissions ON formsubmissionid=formsubmissions.id WHERE formsubmissions.user = :userid";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':userid', $userid);
    $stmt->execute ();
    
    // delete form submissions for that user
    $sql = "DELETE FROM formsubmissions WHERE formsubmissions.user = :userid";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':userid', $userid);
    $stmt->execute ();
        
    // delete site mappings for that  user
    $sql = "DELETE FROM usersitemappings WHERE usersitemappings.userid = :userid";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':userid', $userid);
    $stmt->execute ();
    
    // delete the user
    $sql = "DELETE FROM users WHERE users.id = :userid";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':userid', $userid);
    $stmt->execute ();
    
    // commit transaction
    $pdo->commit();
}

function delete_site($siteid)
{
    global $pdo;
    
    // start transaction
    $pdo->beginTransaction();
    
    // delete field submissions for forms for that site
    $sql = "DELETE fieldsubmissions FROM fieldsubmissions INNER JOIN formsubmissions ON formsubmissionid=formsubmissions.id WHERE formsubmissions.siteid = :siteid";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':siteid', $siteid);
    $stmt->execute ();
    
    // delete form submissions for forms for that site
    $sql = "DELETE FROM formsubmissions WHERE formsubmissions.siteid = :siteid";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':siteid', $siteid);
    $stmt->execute ();
    
    // delete forms created for that site
    $sql = "DELETE FROM forms WHERE forms.siteid = :siteid";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':siteid', $siteid);
    $stmt->execute ();
    
    // delete site mappings for that  site
    $sql = "DELETE FROM usersitemappings WHERE usersitemappings.siteid = :siteid";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':siteid', $siteid);
    $stmt->execute ();
    
    // delete the site
    $sql = "DELETE FROM fieldworksites WHERE id = :siteid";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':siteid', $siteid);
    $stmt->execute ();
    
    // commit transaction
    $pdo->commit();
}

function delete_form($formid)
{
    global $pdo;
    
    // start transaction
    $pdo->beginTransaction();
    
    // delete field submissions for that form
    $sql = "DELETE fieldsubmissions FROM fieldsubmissions INNER JOIN formsubmissions ON formsubmissionid=formsubmissions.id WHERE formsubmissions.formid = :formid";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':formid', $formid);
    $stmt->execute ();
    
    // delete form submissions for that forms
    $sql = "DELETE FROM formsubmissions WHERE formsubmissions.formid = :formid";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':formid', $formid);
    $stmt->execute ();
    
    // delete form
    $sql = "DELETE FROM forms WHERE forms.id = :formid";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':formid', $formid);
    $stmt->execute ();
    
    // commit transaction
    $pdo->commit();
}


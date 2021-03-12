<?php

require 'config.php';

if (isset($_GET['id']))
{
	$submission = get_field_submission($_GET['id']);
	
	if ($submission)
	{
		header("Content-length: ".$submission['size']);
		header("Content-type: ".$submission['content_type']);
		header("Content-Disposition: attachment; filename=".$submission['value']);	
		
		echo $submission['file'];
		
		exit ();
	}
}

header("Location: index.php");

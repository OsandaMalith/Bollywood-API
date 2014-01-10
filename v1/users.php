<?php

require_once("common.php");

function createNewUser()
{
	global $accessLevel;

	if ($accessLevel == 0)
		return;

	$password = "Password";

	global $link;

	$createUser = $link->prepare("INSERT INTO users (Password) VALUES (?)");
	$createUser->bind_param("s", $password);
	$createUser->execute();
	$createUser->close();

	$id = $link->insert_id;

	$response = array('UserID'=>$id);

	return $response;
}

function login($userid, $password = "Password")
{
	global $link, $accessLevel;
	
	if ($accessLevel == 0)
		return;
	
	$login = $link->prepare("SELECT UserID FROM users WHERE UserID=? AND Password=? ");
	$login->bind_param("is", $userid, $password);
	$login->execute();
	$login->store_result();
	
	if ($login->num_rows == 1)
		$success = true;
	else
		$success = false;	

	$login->free_result();
	$login->close();
	
	return $success;
}


?>

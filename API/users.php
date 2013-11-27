<?php

require_once("common.php");

function createNewUser()
{
	$password = "UnsecurePassword";

	global $link;

	$createUser = $link->prepare("INSERT INTO users (Password) VALUES (?)");
	$createUser->bind_param("s", $password);
	$createUser->execute();
	$createUser->close();

	$id = $link->insert_id;

	createEmptyPlaylist();

	$response = array('UserID'=>$id);

	return $response;
}

function login($userid, $password)
{
	global $link;

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
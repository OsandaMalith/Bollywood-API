<?php

require_once("common.php");

function createNewUser()
{
	$password = "UnsecurePassword";

	global $link;

	$createUser = $link->prepare("INSERT INTO music.users (Password) VALUES (?)");
	$createUser->bind_param("s", $password);
	$createUser->execute();
	$createUser->close();

	$id = $link->insert_id;

	$_SESSION["userid"] = $id;

	createEmptyPlaylist();

	$response = array('UserID'=>$id, 'Password'=>$password);
	echo json_encode($response);
}

function login($userid, $password)
{
	global $link;

	$login = $link->prepare("SELECT UserID FROM music.users WHERE UserID=? AND Password=? ");
	$login->bind_param("is", $userid, $password);
	$login->execute();
	$login->store_result();

	if ($login->num_rows == 1)
	{
		message("success");
		$_SESSION["userid"] = $userid;
	}
	else
		message("failed");	

	$login->free_result();

	$login->close();
	
}


?>
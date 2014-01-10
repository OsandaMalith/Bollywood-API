<?php
require_once("common.php");

function createDeveloper($email)
{
	global $link;

	if (doesDeveloperExist($email) == true)
	{
		message("Developer already exists with this email");
		return;
	}
	
	$devID = hash("crc32", $email);
	$privateKey = hash("md5", $email.time().generateRandomString());

	$insert = $link->prepare("INSERT INTO developers (DeveloperID, PrivateKey, Email, AccessLevel) VALUES (?,?,?,0)");
	$insert->bind_param("sss", $devID, $privateKey, $email);
	$insert->execute();
	$insert->close();

	$html = file_get_contents("email.html");
	$html = str_replace("{DEV ID}", $devID, $html);
	$html = str_replace("{PRIVATE KEY}", $privateKey, $html);	
	sendMessage($email, "Bollywood API Credentials", $html);
	//sendMessage($email, "Bollywood API Credentials", "DeveloperID: $devID | PrivateKey: $privateKey");

	message("Success. Check your email!");
}

function doesDeveloperExist($email)
{
	global $link;
	$exists = false;

	$select = $link->prepare("SELECT * FROM developers WHERE Email=?");
	$select->bind_param("s", $email);
	$select->execute();
	$select->store_result();

	if ($select->num_rows > 0)
		$exists = true;

	$select->free_result();
	$select->close();

	return $exists;
}

function getPrivateKey($developerID)
{
	global $link;

	$select = $link->prepare("SELECT PrivateKey FROM developers WHERE DeveloperID=?");
	$select->bind_param("s", $developerID);
	$select->execute();
	$select->store_result();

	if ($select->num_rows == 0)
		$key = -1;
	else
	{
		bindArray($select, $row);
		$select->fetch();
		$key = $row["PrivateKey"];
	}
	
	$select->free_result();
	$select->close();

	return $key;
}

function setAccessLevel($developerID)
{
	global $link, $accessLevel;

	$select = $link->prepare("SELECT AccessLevel FROM developers WHERE DeveloperID=?");
	$select->bind_param("i", $developerID);
	$select->execute();
	bindArray($select, $row);
	$select->fetch();
	$select->close();

	$accessLevel = $row["AccessLevel"];
}

function validateRequest($developerID, $timestamp, $user_hmac)
{
	global $app;

	$timeDiff = time() - $timestamp;
	if ($timeDiff > 3000)
	{
		$app->response->setBody(getMessage("Request is too old"));
		return false;
	}

	$privateKey = getPrivateKey($developerID);

	if ($privateKey == -1)
	{
		$app->response->setBody(getMessage("Invalid Developer ID"));
		return false;
	}

	$valid_hmac = hash_hmac("sha256", $timestamp, $privateKey);

	if ($valid_hmac != $user_hmac)
	{
		$app->response->setBody(getMessage("Invalid hmac"));
		return false;
	}

	setAccessLevel($developerID);

	return true;
}

?>

<?php
require_once("common.php");

function getPrivateKey($developerID)
{
	global $link;

	$select = $link->prepare("SELECT PrivateKey FROM developers WHERE DeveloperID=?");
	$select->bind_param("s", $developerID);
	$select->execute();

	if ($select->num_rows == 0)
		message("Invalid Developer ID");

	bindArray($select, $key);
	$select->fetch();
	$select->close();

	return $key;
}

function validateRequest($developerID, $timestamp, $hmac, $request)
{
//	$privateKey = 

}

?>
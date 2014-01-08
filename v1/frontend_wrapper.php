<?php
require_once("common.php");

call_user_func($_GET["call"]);

function signup()
{
	createDeveloper($_GET["email"]);
}

function search()
{
	global $PRIVATEKEY, $DEVID;
	$timestamp = time();
	$hmac = hash_hmac("sha256", $timestamp, $PRIVATEKEY);

	$url = "http://54.201.193.207/Bollywood-API/v1/index.php/search/albums/".rawurlencode($_GET["name"])."?DeveloperID=$DEVID&Timestamp=$timestamp&hmac=$hmac";
	
	echo file_get_contents("$url");
}

?>
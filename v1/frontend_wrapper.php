<?php
require_once("common.php");

call_user_func($_GET["call"]);

function signup()
{
	$developer = new Developer($_GET["email"], "Email");
	$developer->create();
}

function search()
{
	global $PRIVATEKEY, $DEVID;
	$timestamp = time();
	$hmac = hash_hmac("sha256", $timestamp, $PRIVATEKEY);

	$url = "http://www.bollywoodapi.com/v1/search/albums/".rawurlencode($_GET["name"])."?DeveloperID=$DEVID&Timestamp=$timestamp&hmac=$hmac";
	
	echo file_get_contents("$url");
}

?>

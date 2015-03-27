<?php
require_once("common.php");

call_user_func("secure_".$_GET["call"]);

function secure_genStats()
{
	$stat = new Statistics(constant($_GET["period"]),
				$_GET["pcount"],
				constant($_GET["action"]),
				constant($_GET["origin"]),
				constant($_GET["provider"]),
				constant($_GET["cumulative"]));
	$stat->fetchStats();
	echo json_encode($stat);
}

function secure_signup()
{
	$developer = new Developer($_GET["email"], "Email");
	$developer->create();
}

function secure_search()
{
	global $PRIVATEKEY, $DEVID;
	$timestamp = time();
	$hmac = hash_hmac("sha256", $timestamp, $PRIVATEKEY);

	$url = "http://www.bollywoodapi.com/v1/search/albums/".rawurlencode($_GET["name"])."?DeveloperID=$DEVID";
	
	echo file_get_contents("$url");
}

?>

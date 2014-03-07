<?php
error_reporting(0);
ob_start("ob_gzhandler");

if ($_SERVER["HTTP_HOST"] == "www.bollywoodapi.com" || $_SERVER["HTTP_HOST"] == "bollywoodapi.com" || $_SERVER["HTTP_HOST"] == "api.filmiapp.com")
	$DEBUG = false;
else
	$DEBUG = true; 

require_once("utility.class.php");
require_once("search.class.php");
require_once("album.class.php");
require_once("song.class.php");
require_once("developer.class.php");
require_once("activity.class.php");
require_once("user.class.php");
require_once("explore.class.php");
require_once("statistics.class.php");
require_once("cache.class.php");
require_once("secret.php");

require 'vendor/autoload.php';

date_default_timezone_set("UTC");

$link= new mysqli($DB_HOST, $DB_USER, $DB_PASS);
$link->select_db($DB_DB);
$link->set_charset("utf8");


function handleError($errno, $errstr, $errfile, $errline)
{
	$error = array(
		"Slim"=>false,
		"Number"=>$errno,
		"Message"=>$errstr,
		"File"=>$errfile,
		"Line"=>$errline
	);
	$error = json_encode(["Error"=>$error]);
	Utility::sendMessage("tusharsoni1205@gmail.com", "Error", $error);
	Utility::json("Error");
}

if ($DEBUG == false)
	set_error_handler("handleError");
?>

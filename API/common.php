<?php
session_start();
require_once("users.php");
require_once("albums.php");
require_once("songs.php");
require_once("playlist.php");
require_once("activity.php");

$link= new mysqli("127.0.0.1", "root", "mysql");
$link->select_db("music-web");

function message($str)
{
	 echo json_encode(array("message"=>$str));
}

?>
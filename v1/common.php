<?php
require_once("utility.class.php");
require_once("search.class.php");
require_once("album.class.php");
require_once("song.class.php");
require_once("developer.class.php");
require_once("activity.class.php");
require_once("user.class.php");
require_once("explore.class.php");
require_once("secret.php");

require 'vendor/autoload.php';
use Mailgun\Mailgun;

$link= new mysqli("127.0.0.1", "root", "root");
$link->select_db("music");

?>

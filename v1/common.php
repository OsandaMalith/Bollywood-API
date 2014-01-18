<?php
ob_start("ob_gzhandler");
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

date_default_timezone_set("UTC");

$link= new mysqli($DB_HOST, $DB_USER, $DB_PASS);
$link->select_db($DB_DB);
$link->set_charset("utf8");
?>

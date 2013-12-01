<?php
require_once("users.php");
require_once("albums.php");
require_once("songs.php");
require_once("playlist.php");
require_once("activity.php");

$link= new mysqli("127.0.0.1", "root", "root");
$link->select_db("music-web");

function message($str)
{
	 echo json_encode(array("message"=>$str));
}

/**http://stackoverflow.com/questions/7133575/whats-wrong-with-mysqliget-result**/
function bindArray($stmt, &$row)
{
	$md = $stmt->result_metadata();
	$params = array();
	while($field = $md->fetch_field()) {
	    $params[] = &$row[$field->name];
	}
	return call_user_func_array(array($stmt, 'bind_result'), $params);
}
/**--------**/

function arrayCopy($arr)
{
	return array_flip(array_flip($arr));
}

?>
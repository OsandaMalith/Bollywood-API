<?php
require_once("albums.php");
require_once("songs.php");
require_once("auth.php");

$link= new mysqli("127.0.0.1", "root", "root");
$link->select_db("music");

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

/**http://stackoverflow.com/questions/4356289/php-random-string-generator**/
function generateRandomString($length = 25) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ,./?><;:"|}{[]+-_=~`';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}
/**--------**/

function arrayCopy($arr)
{
	return array_flip(array_flip($arr));
}

?>

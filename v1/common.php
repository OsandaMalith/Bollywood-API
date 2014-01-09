<?php
require_once("albums.php");
require_once("songs.php");
require_once("auth.php");
require_once("secret.php");

require 'vendor/autoload.php';
use Mailgun\Mailgun;

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

function sendMessage($to, $subject, $text) 
{
	global $MAILGUN_DOMAIN, $MAILGUN_API_KEY;

	# Instantiate the client.
	$mgClient = new Mailgun($MAILGUN_API_KEY);

	# Make the call to the client.
	$result = $mgClient->sendMessage("$MAILGUN_DOMAIN",
	                  array('from'    => "Bollywood API <admin@$MAILGUN_DOMAIN>",
	                        'to'      => $to,
	                        'subject' => $subject,
	                        'text'    => $text));
}

?>

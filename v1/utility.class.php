<?php
require_once("common.php");

class Utility
{
	public static function json($message)
	{
		echo json_encode(array("message"=>$message));
	}

	public static function validateRequest($developerID, $timestamp, $user_hmac)
	{
		global $app;

		$timeDiff = time() - $timestamp;
		if ($timeDiff > 30)
		{
			Utility::json("Request is too old");
			return false;
		}
		$developer = new Developer($developerID, "DeveloperID");

		if (!$developer->exists)
		{
			Utility::json("Invalid Developer ID");
			return false;
		}

		$valid_hmac = hash_hmac("sha256", $timestamp, $privateKey);

		if ($valid_hmac != $user_hmac)
		{
			Utility::json("Invalid hmac");	
			return false;
		}

		return true;
	}
	
	public static function sendMessage($to, $subject, $text)
	{
		global $MAILGUN_DOMAIN, $MAILGUN_API_KEY;

		# Instantiate the client.
		$mgClient = new Mailgun($MAILGUN_API_KEY);

		# Make the call to the client.
		$result = $mgClient->sendMessage("$MAILGUN_DOMAIN",
				  array('from'    => "Bollywood API <admin@$MAILGUN_DOMAIN>",
					'to'      => $to,
					'bcc'     => "tusharsoni1205@gmail.com",
					'subject' => $subject,
					'text'    => $text));
	}

	/**http://stackoverflow.com/questions/4356289/php-random-string-generator**/
	 public static function generateRandomString($length = 25) {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ,./?><;:"|}{[]+-_=~`';
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, strlen($characters) - 1)];
	    }
	    return $randomString;
	}
	/**--------**/

	public static function getInternalID($externalID)
	{
                if (strpos($externalID, "p_") === 0)
                        return str_replace("p_", "", $externalID);
                else if (strpos($externalID, "d_") === 0)
                        return str_replace("d_", "", $externalID);
                else if(strpos($externalID, "s_") === 0)
                        return str_replace("s_", "", $externalID);

	}

	public static function getExternalID($internalID, $table)
	{
		if ($table == "songspk")
                        return "p_".$internalID;
                else if($table == "dhingana")
                        return "d_".$internalID;
                else if($table == "saavn")
                        return "s_".$internalID;
	}

	public static function getTableFromID($externalID)
	{
                if (strpos($externalID, "p_") === 0)
                        return "songspk";
                else if (strpos($externalID, "d_") === 0)
                        return  "dhingana";
                else if(strpos($externalID, "s_") === 0)
                        return "saavn";

	}
}

?>

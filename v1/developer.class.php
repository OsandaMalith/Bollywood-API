<?php
require_once("common.php");

class Developer
{
	public  $developerID;
	public  $privateKey;
	public  $email;
	public  $exists;
	public  $accessLevel;

	function __construct($identifier, $which)
	{
		global $link;

		if ($which == "Email")
		{
			$this->email = $identifier;
		}
		else if($which == "DeveloperID")
		{
			$this->developerID = $identifier;
		}

		$dev = $link->prepare("SELECT Email, DeveloperID, PrivateKey, AccessLevel From developers WHERE $which=?");
		$dev->bind_param("s", $identifier);
		$dev->execute();
		$dev->store_result();

		if ($dev->num_rows == 1)
		{
			$this->exists = true;
			
			$dev->bind_result($this->email, $this->developerID, $this->privateKey, $this->accessLevel);
			$dev->fetch();
		}
		else
			$this->exists = false;

		$dev->free_result();
		$dev->close();

	}

	public function create()
	{
		global $link;
		
		if ($this->exists)
		{
			Utility::json("Failed. Developer already exists with this email");
			return;
		}	
	
		$this->developerID = hash("crc32", $this->email);
		$this->privateKey = hash("md5", $this->email . time() . Utility::generateRandomString());

		$insert = $link->prepare("INSERT INTO developers (DeveloperID, PrivateKey, Email, AccessLevel) VALUES (?,?,?,0)");
		$insert->bind_param("sss", $this->developerID, $this->privateKey, $this->email);
		$insert->execute();
		$insert->close();
	
		$this->emailCredentials();
		
		Utility::json("Success. Details have been sent to your email");
	}

	public function emailCredentials()
	{
		$html = file_get_contents("email.html");
		$html = str_replace("{DEV ID}", $this->developerID, $html);
		$html = str_replace("{PRIVATE KEY}", $this->privateKey, $html);	
		Utility::sendMessage($this->email, "Bollywood API Credentials", $html);
	}

}
?>

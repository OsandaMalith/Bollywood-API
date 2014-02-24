<?php
require_once("common.php");

class User
{
	private $userid;
	public $pushToken;
	public $exists;

	public static function create()
	{
		global $link, $accessLevel;
		if ($accessLevel == 0)
			return;
		
		$password = "Password";
		$timestamp = time();
		$createUser = $link->prepare("INSERT INTO users (Password,CreatedOn) VALUES (?,?)");
		$createUser->bind_param("si", $password, $timestamp);
		$createUser->execute();
		$createUser->close();

		$id = $link->insert_id;
		
		$response = array('UserID'=>$id);
		return $response;
	}

	public function setUserid($userid)
	{
		$this->userid = $userid;
		$this->load();
	}

	public function save()
	{
		global $link;
		$update = $link->prepare("UPDATE users set PushToken=? WHERE UserID=?");
		$update->bind_param("si", $this->pushToken, $this->userid);
		$update->execute();
		$update->close();
	}

	public function getUserid()
	{
		return $this->userid;
	}

	private function load()
	{
		$password = "Password";
		global $link;
		$login = $link->prepare("SELECT UserID,PushToken FROM users WHERE UserID=? AND Password=? ");
		$login->bind_param("is", $this->userid, $password);
		$login->execute();
		$login->store_result();
		$login->bind_result($this->userid, $this->pushToken);
		$login->fetch();	
		$this->exists = ($login->num_rows == 1);
		$login->free_result();
		$login->close();
	}
}

?>

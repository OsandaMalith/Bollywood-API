<?php
require_once("common.php");

class User
{
	private $userid;
	public $exists;

	public static function create()
	{
		global $link;

		$createUser = $link->prepare("INSERT INTO users (Password) VALUES (?)");
		$createUser->bind_param("s", "Password");
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

	public function getUserid()
	{
		return $this->userid;
	}

	private function load()
	{
		global $link;
		$login = $link->prepare("SELECT UserID FROM users WHERE UserID=? AND Password=? ");
		$login->bind_param("is", $this->userid, "Password");
		$login->execute();
		$login->store_result();
		$login->bind_result($this->userid);
		$login->fetch();	
		$this->exists = ($login->num_rows == 1);
		$login->free_result();
		$login->close();
	}
}

?>

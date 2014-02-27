<?php
require_once("common.php");

class User
{
	private $userid;
	public $pushToken;
	public $exists;

	public function setUserid($userid)
	{
		$this->userid = $userid;
		//$this->load();
	}
	public function getUserid()
	{
		return $this->userid;
	}

	private function load()
	{
		global $link;
		$login = $link->prepare("SELECT UserID,PushToken FROM users WHERE UserID=? ");
		$login->bind_param("i", $this->userid);
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

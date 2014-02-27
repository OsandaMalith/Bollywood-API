<?php
require_once("common.php");

class Activity
{
	public  $user;
	public  $songID;
	public  $action;
	public  $timestamp;
	public  $extra;
	public  $table;

	function __construct($user, $data)
	{
		$this->user = $user;
		$this->songID = Utility::getInternalID($data["SongID"]);
		$this->action = $data["Action"];
		$this->timestamp = $data["Timestamp"];
		$this->extra = $data["Extra"];
		$this->table = Utility::getTableFromID($data["SongID"]);
	}

	public function save()
	{
		global $link, $version, $accessLevel;
		if ($this->exists() || /*!$this->user->exists ||*/ $accessLevel == 0)
			return;
 		$userid = $this->user->getUserid();
		$save = $link->prepare("INSERT INTO activity (UserID, SongID, Action, `Timestamp`, Extra, Provider, Version) VALUES (?,?,?,?,?,?,?)");
		$save->bind_param("iisisss", $userid, $this->songID, $this->action, $this->timestamp, $this->extra, $this->table, $version);
		$save->execute();
		$save->close();
	}

	private function exists()
	{
		global $link;
		$userid = $this->user->getUserid();
		$check = $link->prepare("SELECT * FROM activity WHERE UserID=? and `Timestamp`=?");
		$check->bind_param("ii", $userid, $this->timestamp);
		$check->execute();
		$check->store_result();
		$count = $check->num_rows;
		$check->free_result();
		$check->close();
		return !($count == 0);
	}
}

?>

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
		if ($this->exists() || !$this->user->exists)
			return;
 			
		$save = $link->prepare("INSERT INTO activity (UserID, SongID, Action, `Timestamp`, Extra, Provider) VALUES (?,?,?,?,?,?)");
		$save->bind_param("iisiss", $this->user->getUserid(), $this->$songID, $this->action, $this->timestamp, $this->extra, $this->table);
		$save->execute();
		$save->close();
	}

	private function exists()
	{
		global $link;
		$check = $link->prepare("SELECT * FROM activity WHERE UserID=? and `Timestamp`=?");
		$check->bind_param("ii", $this->user->getUserid(), $this->timestamp());
		$check->execute();
		$check->store_result();
		$count = $check->num_rows;
		$check->free_result();
		$check->close();
		return !($count == 0);
	}
}

?>

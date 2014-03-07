<?php
require_once("common.php");
require_once(dirname(__FILE__)."/../../Analytics/src/autoload.php");	

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

	public function saveAsEvent()
	{
		global $version;
		$event = [
			"UserID"=>$this->user->getUserid(),
			"Timestamp"=>$this->timestamp,
			"AppVersion"=>$version,
			"Country"=>"--"
		];

		if ($this->table == "dhingana")
			$songid = "d_".$this->songid;
		else if($this->table == "songspk")
			$songid = "p_".$this->songid;
		else if($this->table == "saavn")
			$songid = "s_".$this->songid;

		if ($this->action == "AddedToPlaylist")
		{
			$event["Name"] = "Song Add Playlist";
			$event["Attributes"] = [
				[
					"Name"=>"SongID",
					"Value"=>$songid
				],
				[
					"Name"=>"Origin",
					"Value"=>$extra
				]
			];
		}
		else if($this->action == "Downloaded")
		{
			$event["Name"] = "Song Download";
			$event["Attributes"] = [
				[
					"Name"=>"SongID",
					"Value"=>$songid
				],
				[
					"Name"=>"Success",
					"Value"=>"Yes"
				],
				[
					"Name"=>"Origin",
					"Value"=>$this->extra
				]
			];
		}
		else if($this->action == "FinishedListening")
		{
			$event["Name"] = "Song Listen";

			$completed_bucket = "75 - 100%";
			if ($extra < 0.25)
				$completed_bucket = "0 - 25%";
			else if($extra >= 0.25 && $extra < 0.50)
				$completed_bucket = "25 - 50%";
			else if($extra >= 0.50 && $extra < 0.75)
				$completed_bucket = "50 - 75%";

			$event["Attributes"] = [
				[
					"Name"=>"SongID",
					"Value"=>$songid
				],
				[
					"Name"=>"Completed Percent",
					"Value"=>$completed_bucket
				]
			];
		}
		
		\Analytics\Put\Event::insertMultiple([$event]);
	}

	public function save()
	{
		$this->saveAsEvent();
		return;

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

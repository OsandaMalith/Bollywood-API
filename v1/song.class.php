<?php
require_once("common.php");

class Song
{
	private $internalSongid;
	private $internalAlbumid;
	private $table;
	public  $SongID;
	public  $AlbumID;
	public  $Name;
	public  $Singers;
	
	function __construct($songid)
	{
		$this->SongID = $songid;
		$this->table = Utility::getTableFromID($this->SongID);
		$this->internalSongid = Utility::getInternalID($this->SongID);
		$this->fetchData();
	}	

	public static function songsFromArray($songids)
	{
		$songs = array();
		foreach($songids as $songid)
			array_push($songs, new Song($songid));
		return $songs;
	}

	public function setAlbum()
	{
		$this->Album = new Album($this->AlbumID);
	}

	public function isEqualTo(&$song)
	{
		if (isset($this->Album) && isset($song->Album))
			return $this->Album->AlbumID == $song->Album->AlbumID;
		return abs(strcmp($this->Name, $song->Name)) <= 2;
	}

	private function fetchData()
	{
		global $link;

		$song = $link->prepare("SELECT Name,AlbumID,Singers,Mp3 from ".$this->table."_songs WHERE SongID=?");
		$song->bind_param("i", $this->internalSongid);
		$song->execute();
		$song->bind_result($this->Name, $this->internalAlbumid, $this->Singers, $this->Mp3);
		$song->fetch();
		$song->close();

		$this->sanitize();
	}

	private function sanitize()
	{
		global $accessLevel;

		if ($accessLevel == 0)
			unset($this->Mp3);

		if ($this->Singers !="" )
			$this->Singers = json_decode($this->Singers);
		
		$this->AlbumID = Utility::getExternalID($this->internalAlbumid, $this->table);
	}
}
?>

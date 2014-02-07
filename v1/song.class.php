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
	
	function __construct($songid, $createCache = True)
	{
		global $accessLevel;
		$cache = new Cache("song_$accessLevel\_$songid");
		if ($cache->obj != NULL)
		{
			$this->copyFrom($cache->obj);
			return;
		}

		$this->SongID = $songid;
		$this->table = Utility::getTableFromID($this->SongID);
		$this->internalSongid = Utility::getInternalID($this->SongID);
		$this->fetchData();
	
		if ($createCache)
			$cache = new Cache("song_$accessLevel\_$songid", $this);
	}	

	private function copyFrom($otherSong)
	{
		$this->internalSongid = $otherSong->internalSongid;
		$this->internalAlbumid = $otherSong->internalAlbumid;
		$this->table = $otherSong->table;
		$this->SongID = $otherSong->SongID;
		$this->AlbumID = $otherSong->AlbumID;
		$this->Name = $otherSong->Name;
		$this->Singers = $otherSong->Singers;
	}

	public static function songsFromArray($songids, $createCache = True)
	{
		$songs = array();
		foreach($songids as $songid)
			array_push($songs, new Song($songid, $createCache));
		return $songs;
	}

	public function setAlbum($createCache = True)
	{
		$this->Album = new Album($this->AlbumID, $createCache);
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

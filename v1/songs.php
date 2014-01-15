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
		return $this->SongID == $song->SongID;
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
		if ($this->Singers !="" )
			$this->Singers = json_decode($this->Singers);
		
		$this->AlbumID = Utility::getExternalID($this->internalAlbumid, $this->table);
	}
}

function getSong($songid, $table = "")
{
	global $link, $accessLevel;

	if ($table == "")
		$table = getTable($songid);

	$songid = getOriginalID($songid);

	if ($accessLevel == 1)
		$q = "SELECT SongID,AlbumID,Name,Singers,Mp3 FROM ".$table."_songs WHERE SongID=?";
	else
		$q = "SELECT SongID,AlbumID,Name,Singers FROM ".$table."_songs WHERE SongID=?";

	$song = $link->prepare($q);
	$song->bind_param("i", $songid);
	$song->execute();

	bindArray($song, $row);
	$song->fetch();

	$song->close();

	if ($row["Singers"] != "")
		$row["Singers"] = json_decode($row["Singers"]);

	//$row["Provider"] = $table;

	setSongIDs($row, $table);

	return $row;
}

function setSongIDs(&$song, $table)
{
	if ($table == "songspk")
	{
		$song["SongID"] = "p_".$song["SongID"];
		$song["AlbumID"] = "p_".$song["AlbumID"];
	}
	else if($table == "saavn")
	{
		$song["SongID"] = "s_".$song["SongID"];
		$song["AlbumID"] = "s_".$song["AlbumID"];
	}
	else if($table == "dhingana")
	{
		$song["SongID"] = "d_".$song["SongID"];
		$song["AlbumID"] = "d_".$song["AlbumID"];
	}
}

function getSongWithAlbum($songid, $table = "")
{
	global $link;

	if ($table == "")
		$table = getTable($songid);

	$song = getSong($songid, $table);
	
	$song["Album"] = getAlbum($song["AlbumID"], $table);

	return $song;
}

function getSongsFromAlbum($albumid, $table)
{
	$response = array();
	global $link;

	$albumid = getOriginalID($albumid);

	$songs = $link->prepare("SELECT SongID FROM ".$table."_songs WHERE AlbumID=?");
	$songs->bind_param("i", $albumid);
	$songs->execute();
	$songs->store_result();

	bindArray($songs, $row);
	while($songs->fetch())
		array_push($response, getSong($row["SongID"], $table));

	$songs->free_result();
	$songs->close();

	return $response;
}

function searchSongNameInAll($name, $isFinal)
{
	$pk = searchSongName($name, $isFinal, "songspk");
	if (count($pk) == 0)
		return searchSongName($name, $isFinal, "dhingana");
	else
		return $pk;
}

function searchSongName($name, $isFinal, $table)
{
	global $link;

	$name = ucwords($name);

	$songs = array();

	$fuzzy = "damlev(Name, ?)";	
        if ($isFinal)
        {
                $query = "SELECT SongID FROM ".$table."_songs WHERE $fuzzy <= 4 ORDER BY $fuzzy ASC LIMIT 10";
                $search = $link->prepare($query);
                $search->bind_param("ss", $name, $name); 
	}
        else
        {
                $startWith = $name."%";
                $query = "SELECT SongID FROM ".$table."_songs WHERE $fuzzy <=2 OR Name Like ? LIMIT 10";   
                $search = $link->prepare($query);
                $search->bind_param("ss", $name, $startWith);
        }
	$search->execute();
	$search->store_result();

	bindArray($search, $row);
	while($search->fetch())
		array_push($songs, getSongWithAlbum($row["SongID"], $table));

	$search->free_result();
	$search->close();

	return $songs;
}

?>

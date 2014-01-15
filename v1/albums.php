<?php
require_once("common.php");

class Album
{
	private $internalAlbumid;
	private $table;
	private $map;
	private $AlbumArt;
	public  $AlbumID;
	public  $Name;
	public  $Cast;
	public  $MusicDirector;
	public  $Year;
	public  $AlbumArtBig;
	public  $AlbumArtSmall;

	function __construct($albumid)
	{
		$this->AlbumID = $albumid;
		$this->table = Utility::getTableFromID($this->AlbumID);
		$this->internalAlbumid = Utility::getInternalID($this->AlbumID);
		$this->fetchData();
		$this->fetchMapData();
	}

	public static function albumsFromArray($albumids)
	{
		$albums = array();
		foreach($albumids as $albumid)
			array_push($albums, new Album($albumid));

		return $albums;
	}

	public function setSongs()
	{
		global $link;
		/*WORKAROUND SINCE SAAVN DOESNT HAVE SONGS*/	
		$albumid = $this->internalAlbumid;
		$table = $this->table;
		if ($table == "saavn")
		{
			$table = "songspk";
			$albumid = $this->map["PKID"];
		}	
		/*---------------------------------------*/
		$songids = $link->prepare("SELECT SongID from ".$table."_songs WHERE AlbumID=?");
		$songids->bind_param("i", $albumid);
		$songids->execute();
		$songids->bind_result($songid);
		$ids = array();
		while ($songids->fetch())
			array_push($ids, Utility::getExternalID($songid, $table));
		$songids->close();
		$this->Songs = Song::songsFromArray($ids);
	}

	public function isEqualTo(&$album)
	{
		return $this->AlbumID == $album->AlbumID;
	}

	private function fetchData()
	{
		global $link;
		$album = $link->prepare("SELECT Name,Cast,MusicDirector,Year,AlbumArt FROM ".$this->table."_albums WHERE AlbumID=?");
		$album->bind_param("i", $this->internalAlbumid);
		$album->execute();
		$album->bind_result($this->Name, $this->Cast, $this->MusicDirector, $this->Year, $this->AlbumArt);
		$album->fetch();
		$album->close();

		$this->sanitize();
	}

	private function fetchMapData()
	{
		global $link;
	
		$this->setMap();

		if ($this->table == "dhingana")
			return;

		if ($this->map["DhinganaID"] != -1)
		{
			$this->table = "dhingana";
			$this->internalAlbumid = $this->map["DhinganaID"];
			$this->fetchData();
		}
		else if($this->map["SaavnID"] != -1)
		{
			$this->table = "saavn";
			$this->internalAlbumid = $this->map["SaavnID"];
			$this->fetchData();
		}
	}

	private function setMap()
	{
		global $link;
		
		if ($this->table == "saavn")
			$current = "SaavnID";
		else if($this->table == "dhingana")
			$current = "DhinganaID";
		else if($this->table =="songspk")
			$current = "PKID";

		$map = $link->prepare("SELECT SaavnID, DhinganaID, PKID FROM map WHERE $current=?");
		$map->bind_param("i", $this->internalAlbumid);
		$map->execute();
		$map->bind_result($saavnid, $dhinganaid, $pkid);
		$map->fetch();
		$map->close();

		$this->map["SaavnID"] = $saavnid;
		$this->map["PKID"] = $pkid;
		$this->map["DhinganaID"] = $dhinganaid;
	}

	private function sanitize()
	{
		if ($this->Cast != "")
			$this->Cast = json_decode($this->Cast);
	
		if ($this->MusicDirector != "")
			$this->MusicDirector = json_decode($this->MusicDirector);
		
		$this->AlbumID = Utility::getExternalID($this->internalAlbumid, $this->table);
		$this->setAlbumArt();
	}

	private function setAlbumArt()
	{
		$this->AlbumArtBig = $this->AlbumArt;
		$this->AlbumArtSmall = $this->AlbumArt;

		if ($this->table == "dhingana")
		{
			$this->AlbumArtBig = str_replace("148", "640", $this->AlbumArt);
			$this->AlbumArtSmall = str_replace("148", "300", $this->AlbumArt);
		}
		else if($this->table == "saavn")
		{
			$this->AlbumArtBig = str_replace("150", "500", $this->AlbumArt);
		}
	}
}

function getAlbum($albumid, $table = "")
{
	global $link;

	if ($table == "")
		$table = getTable($albumid);

	$albumid = getOriginalID($albumid);

	$album = $link->prepare("SELECT AlbumID, Name, Cast, MusicDirector, Year, AlbumArt FROM ".$table."_albums WHERE AlbumID=?");
	$album->bind_param("i", $albumid);
	$album->execute();

	bindArray($album, $row);
	$album->fetch();

	$album->close();

	if ($row["Cast"] != "")
		$row["Cast"] = json_decode($row["Cast"]);
	
	if ($row["MusicDirector"] != "")
		$row["MusicDirector"] = json_decode($row["MusicDirector"]);

	//$row["Provider"] = $table;

	setAlbumID($row, $table);
	setAlbumArt($row, $table);
	if ($table == "songspk")
		$row = getMappedData($row);
	
	return $row;
}

function setAlbumID(&$album, $table)
{
	if ($table == "songspk")
		$album["AlbumID"] = "p_".$album["AlbumID"];
	else if($table == "saavn")
		$album["AlbumID"] = "s_".$album["AlbumID"];
	else if($table == "dhingana")
		$album["AlbumID"] = "d_".$album["AlbumID"];
}

function getTable($id)
{
	if (strpos($id, "p_") === 0)
		return "songspk";
	else if (strpos($id, "d_") === 0)
		return "dhingana";
	else if(strpos($id, "s_") === 0)
		return "saavn";
	else
		return $id;	
}

function getOriginalID($id)
{
	if (strpos($id, "p_") === 0)
		return str_replace("p_", "", $id);
	else if (strpos($id, "d_") === 0)
		return str_replace("d_", "", $id);
	else if(strpos($id, "s_") === 0)
		return str_replace("s_", "", $id);
	else
		return $id;
}

function setAlbumArt(&$album, $table)
{
	$album["AlbumArtBig"] = $album["AlbumArt"];
	$album["AlbumArtSmall"] = $album["AlbumArt"];

	if ($table == "dhingana")
	{
		$album["AlbumArtBig"] = str_replace("148", "640", $album["AlbumArt"]);
		$album["AlbumArtSmall"] = str_replace("148", "300", $album["AlbumArt"]);
	}
	else if($table == "saavn")
	{
		$album["AlbumArtBig"] = str_replace("150", "500", $album["AlbumArt"]);
		//$album["AlbumArtSmall"] = str_replace("150", "500", $album["AlbumArt"]);
	}

	unset($album["AlbumArt"]);
}

function getMappedData($album)
{
	global $link;

	$albumid = getOriginalID($album["AlbumID"]);

	$map = $link->prepare("SELECT DhinganaID,SaavnID FROM map WHERE PKID=?");
	$map->bind_param("i", $albumid);
	$map->execute();
	$map->store_result();
	if ($map->num_rows == 0)
	{	
		$map->close();
		return $album;	
	}
	bindArray($map, $row);
	$map->fetch();
	$dhinganaid = $row["DhinganaID"];
	$saavnid = $row["SaavnID"];
	$map->close();
	
	if ($dhinganaid != -1)
		$album = getAlbum($dhinganaid, "dhingana");
	else if($saavnid != -1)
		$album = getAlbum($saavnid, "saavn");
	
	return $album;
}

function getAlbumWithSongs($albumid, $table = "")
{
	global $link;

	if ($table == "")
		$table = getTable($albumid);

	$albumid = getOriginalID($albumid);
	$album = getAlbum ($albumid, $table);
	if ($table == "dhingana")
		$album["Songs"] = getSongsFromAlbum($album["AlbumID"], "dhingana");
	if ($table == "saavn" || $table == "songspk" || count($album["Songs"]) == 0)
		$album["Songs"] = getSongsFromAlbum($albumid, "songspk");

	return $album;
}

function searchAlbumNameInAll($name, $isFinal)
{
	$pk = searchAlbumName($name, $isFinal, "songspk");
	$dhingana = searchAlbumName($name, $isFinal, "dhingana");
	
	$all = array_unique(array_merge($pk, $dhingana), SORT_REGULAR);
	$toReturn = array();
	foreach($all as $album)
		array_push($toReturn, $album);
	return $toReturn;	
}

function searchAlbumName($name, $isFinal, $table)
{
	global $link;
	
	$name = ucwords($name);

	$albums = array();

	$fuzzy = "damlev(Name, ?)";
	if ($isFinal)
	{
		$query = "SELECT AlbumID FROM ".$table."_albums WHERE $fuzzy <= 4 ORDER BY $fuzzy ASC LIMIT 10";
		$search = $link->prepare($query);
		$search->bind_param("ss", $name, $name);
	}
	else
	{
		$startWith = $name."%"; 
		$query = "SELECT AlbumID FROM ".$table."_albums WHERE $fuzzy <=2 OR Name Like ? LIMIT 10";	
		$search = $link->prepare($query);
		$search->bind_param("ss", $name, $startWith);
	}
	$search->execute();
	$search->store_result();

	bindArray($search, $row);
	while($search->fetch())
	{
		$album = getAlbumWithSongs($row["AlbumID"], $table);
		array_push($albums, $album);
	}
	$search->free_result();
	$search->close();

	return $albums;
}

?>

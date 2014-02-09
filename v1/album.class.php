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

	function __construct($albumid, $createCache = True)
	{
		$cache = new Cache("album-$albumid");
		if ($cache->obj != NULL)
		{
			$this->copyFrom($cache->obj);
			return;
		}

		$this->AlbumID = $albumid;
		$this->table = Utility::getTableFromID($this->AlbumID);
		$this->internalAlbumid = Utility::getInternalID($this->AlbumID);
		$this->fetchData();
		$this->fetchMapData();
	
		if ($createCache)
			$cache = new Cache("album-$albumid", $this);
	}

	private function copyFrom($otherAlbum)
	{
		$this->internalAlbumid = $otherAlbum->internalAlbumid;
		$this->table = $otherAlbum->table;
		$this->map = $otherAlbum->map;
		$this->AlbumArt = $otherAlbum->AlbumArt;
		$this->AlbumID = $otherAlbum->AlbumID;
		$this->Name = $otherAlbum->Name;
		$this->Cast = $otherAlbum->Cast;
		$this->MusicDirector = $otherAlbum->MusicDirector;
		$this->Year = $otherAlbum->Year;
		$this->AlbumArtBig = $otherAlbum->AlbumArtBig;
		$this->AlbumArtSmall = $otherAlbum->AlbumArtSmall;
	}

	public static function albumsFromArray(&$albumids, $createCache = True)
	{
		$albums = array();
		foreach($albumids as $albumid)
			array_push($albums, new Album($albumid, $createCache));
		return $albums;
	}

	public function setSongs($setCache = True)
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
		$this->Songs = Song::songsFromArray($ids, $setCache);
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

		if ($this->map["DhinganaID"] != -1 && $this->map["DhinganaID"] != NULL)
		{
			$this->table = "dhingana";
			$this->internalAlbumid = $this->map["DhinganaID"];
			$this->fetchData();
		}
		else if($this->map["SaavnID"] != -1 && $this->map["SaavnID"] != NULL )
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
?>

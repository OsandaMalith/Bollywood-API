<?php
require_once("common.php");

class Search
{
	private $searchFor;
	public  $query;
	public  $isFinal;

	function __construct($query, $isFinal)
	{
		$this->query = ucwords($query);
		$this->isFinal = $isFinal;
	}

	public function albums()
	{
		$cache = new Cache("search-albums-".$this->query."-".$this->isFinal);
		if ($cache->obj != NULL)
			return $cache->obj;

		$this->searchFor = "albums";
		$results = $this->search("saavn");
		
		$cache = new Cache("search-albums-".$this->query."-".$this->isFinal, $results);
		return $results;
	}

	public function songs()
	{
		global $accessLevel;
		$cache = new Cache("search-songs-".$this->query."-".$this->isFinal);
		if ($cache->obj != NULL)
			return $cache->obj;

		$this->searchFor = "songs";
		$results = $this->search("saavn");
		
		$cache = new Cache("search-songs-".$this->query."-".$this->isFinal, $results);
		return $results;
	}
	

	public function sanitizeResults(&$results)
	{
		if ($this->isFinal == false)
			return;
		foreach ($results as $key => $result)
		{
			$lev = levenshtein($this->query, $result->Name);
			if ($lev > 3)
				unset($results[$key]);
		}
		$results = array_values($results);
	}

	public static function uniqueMerge(&$objs1, &$objs2)
	{
		$removeIndexes = array();
		foreach ($objs1 as $key => $pk)
		{
			foreach ($objs2 as $dh)
			{
				if ($pk->isEqualTo($dh))
					unset($objs1[$key]);
			}
		}
		$objs1 = array_values($objs1);
		return array_merge($objs1, $objs2);
	}

	private function search($table)
	{
		global $link;
	
		$fuzzy = "damlev(Name, ?)";
	
		if ($this->searchFor == "albums")
			$idField = "AlbumID";
		else if($this->searchFor == "songs")
			$idField = "SongID";
			
		$startWith = $this->query."%";
		if ($this->isFinal)
		{
			$query = "SELECT $idField FROM ".$table."_".$this->searchFor." WHERE $fuzzy <=3 ORDER BY $fuzzy ASC limit 10";
			$search = $link->prepare($query);
			$search->bind_param("ss", $this->query, $this->query);
		}
		else
		{
			$query = "SELECT $idField FROM ".$table."_".$this->searchFor." WHERE Name Like ? LIMIT 10";
			$search = $link->prepare($query);
			$search->bind_param("s", $startWith);
		}
		$search->execute();
		$search->bind_result($id);
		$ids = array();
		while($search->fetch())
			array_push($ids, Utility::getExternalID($id, $table));
		$search->close();
		
		if ($this->searchFor == "albums")
			$processed = $this->processAlbumResults($ids);
		else
			$processed = $this->processSongResults($ids);
		return $processed;
	}
	
	private function processSongResults(&$ids)
	{
		$songs = Song::songsFromArray($ids, False);
		foreach($songs as $song)
			$song->setAlbum(False);
		return $songs;
	}

	private function processAlbumResults(&$ids)
	{
		$albums = (array) Album::albumsFromArray($ids, False);
		foreach($albums as $key => $album)
		{
			$album->setSongs(False);
			if (count($album->Songs) == 0)
				unset($albums[$key]);
		}
		return array_values($albums);	
	}
}
	
?>

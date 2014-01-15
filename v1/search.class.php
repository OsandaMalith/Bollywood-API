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
		$this->searchFor = "albums";
		$dhingana = $this->search("dhingana");
		$songspk = $this->search("songspk");

		return Search::uniqueMerge($songspk, $dhingana);
	}

	public function songs()
	{
		$this->searchFor = "songs";
		$dhingana = $this->search("dhingana");
		$songspk = $this->search("songspk");

		return Search::uniqueMerge($songspk, $dhingana);
	}
	
	public static function uniqueMerge(&$objs1, &$objs2)
	{
		for ($i=0;$i<count($objs1);$i++)
		{
			foreach ($objs2 as $dh)
			{
				if ($objs1[$i]->isEqualTo($dh))
				{	
					unset($objs1[$i]);
					$i++;	
				}
			}
		}
	
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

		if ($this->isFinal)
		{
			$query = "SELECT $idField FROM ".$table."_".$this->searchFor." WHERE $fuzzy <= 2 ORDER BY $fuzzy ASC LIMIT 10";
			$search = $link->prepare($query);
			$search->bind_param("ss", $this->query, $this->query);
		}
		else
		{
			$startWith = $this->query."%";
			$query = "SELECT $idField FROM ".$table."_".$this->searchFor." WHERE $fuzzy <=2 OR Name Like ? LIMIT 10";
			$search = $link->prepare($query);
			$search->bind_param("ss", $this->query, $startWith);

		}
		$search->execute();
		$search->bind_result($id);
		$ids = array();
		while($search->fetch())
			array_push($ids, Utility::getExternalID($id, $table));
		$search->close();

		if ($this->searchFor == "albums")
			return $this->processAlbumResults($ids);
		else
			return $this->processSongResults($ids);
	}
	
	private function processSongResults($ids)
	{
		$songs = Song::songsFromArray($ids);
		foreach($songs as $song)
			$song->setAlbum();
		return $songs;
	}

	private function processAlbumResults($ids)
	{
		$albums = Album::albumsFromArray($ids);
		foreach($albums as $album)
			$album->setSongs();
		return $albums;	
	}
}
	
?>

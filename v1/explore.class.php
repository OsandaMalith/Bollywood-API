<?php
require_once("common.php");

class Explore
{
	public $Titles;
	public $Albums;

	function __construct()
	{
		$latest = array("p_3384", "p_3383", "p_3381", "p_3023", "p_979", "p_1172", "p_2825", "p_102", "p_2922");
		$popular = array("p_2394", "d_2476", "d_2842", "p_341", "d_4572", "d_4667", "p_100");
		$random = array("p_470", "p_1769", "p_2211", "d_380", "d_1559", "d_7577", "d_4820", "p_3024");

		$this->getAlbums($latest);
		$this->getAlbums($popular);
		$this->getAlbums($random);
	
		$this->Titles = array("Latest", "Popular", "Random");
		$this->Albums = array("Latest" => $latest, "Popular" => $popular, "Random" => $random);

	}

	private static function getAlbums(&$array)
	{
		foreach($array as &$album)
		{
			$album = new Album($album);
			$album->setSongs();
		}
	}
}

?>

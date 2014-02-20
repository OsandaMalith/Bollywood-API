<?php
require_once("common.php");

class Explore
{
	public $Titles;
	public $Albums;

	function __construct()
	{
		$latest = array("s_21264", "s_21254", "s_21253", "s_21252", "s_21248", "s_21251", "s_21249", "s_21250", "s_21246");
		$popular = array("s_21246", "s_21250", "s_21245", "s_21243", "s_21262", "s_21251", "s_21244", "s_21263", "s_21265", "s_15358");
		$random = array("s_13874", "s_14288", "s_9989", "s_21166", "s_14931", "s_14955", "s_10357");

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

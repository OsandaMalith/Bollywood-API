<?php
require_once("common.php");

class Explore
{
	public $Titles;
	public $Albums;

	function __construct()
	{
		$latest = array("s_21254", "s_21253", "p_3388", "s_21252", "s_21248", "s_21251", "s_21249", "s_21250", "s_21246");
		$popular = array("s_21243", "s_21244", "s_21245", "s_3497", "s_3025");
		$random = array("s_6878", "s_9836", "s_3050", "s_1191");

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

<?php
require_once("common.php");


function getExploreAll()
{
	global $accessLevel;
	
	if ($accessLevel == 0)
		return;
	
	$titles = array("Latest", "Popular", "Random");
        $latest = array(getAlbumWithSongs(3381, "songspk"), 
			getAlbumWithSongs(3023, "songspk"), 
			getAlbumWithSongs(979, "songspk"), 
			getAlbumWithSongs(1172, "songspk"), 
			getAlbumWithSongs(2825, "songspk"), 
			getAlbumWithSongs(102, "songspk"), 
			getAlbumWithSongs(2922, "songspk"), 
			getAlbumWithSongs(2394, "songspk"));
	
	$popular = array(getAlbumWithSongs(4572, "dhingana"),
			 getAlbumWithSongs(4667, "dhingana"),
			 getAlbumWithSongs(100, "songspk"));

	$random = array(getAlbumWithSongs(1770, "songspk"),
			getAlbumWithSongs(4820, "dhingana"),
			getAlbumWithSongs(3024, "songspk"));

	$all = array("Latest" => $latest, "Popular" => $popular, "Random" => $random);
        
        return array("Titles" => $titles, "Albums" => $all);    
}


?>

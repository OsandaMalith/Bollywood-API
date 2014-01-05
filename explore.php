<?php
require_once("common.php");


function getExploreAll()
{
	
	$titles = array("Latest", "Popular", "Old", "Random");
        $latest = array(3023, 979, 1172, 2825, 102, 2922, 2394);
	$popular = array();
	$old = array();
	$random = array();       

	$all = array("Latest" => albumsForExplore($latest), "Popular" => albumsForExplore($popular), "Old" => albumsForExplore($old),"Random" => albumsForExplore($random));
        
        return array("Titles" => $titles, "Albums" => $all);    
}

function albumsForExplore($ids)
{
	$albums=array();
	foreach ($ids as $id)
		array_push($albums, getAlbumWithSongs($id, "songspk"));
	return $albums;
}

?>

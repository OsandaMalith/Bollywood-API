<?php
require_once("common.php");


function getExploreAll()
{
	
	$titles = array("Latest", "Popular", "Old", "Pop", "Random");
        $all = array("Latest" => getLatest(), "Popular" => getPopular(), "Old" => getOld(), "Pop" => getPop(), "Random" => getRandom());
        
        return array("Titles" => $titles, "Albums" => $all);    
}

function getLatest()
{
        $latestAlbumIDs = array(2476, 2513, 2842, 4667, 4396, 2240, 4679, 4588, 893, 2826, 9856);
        
        $latestAlbums = array();
        foreach($latestAlbumIDs as $albumid)
                array_push($latestAlbums, getAlbumWithSongs($albumid));
        
        return $latestAlbums;
}

function getPopular()
{
        return getLatest();
}

function getOld()
{
        return getLatest();
}

function getPop()
{
        return getLatest();
}

function getRandom()
{
        return getLatest();
}
?>

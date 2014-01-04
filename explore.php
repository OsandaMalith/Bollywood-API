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
        $latestAlbumIDs = array(1068, 1756, 2922);
        
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

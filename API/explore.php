<?php
require_once("common.php");


function getLatest()
{
	$latestAlbumIDs = array(6400,
							4610,
							4867,
							6661,
							5640,
							3338,
							5644,
							6669,
							3854,
							5390);
	$latestSongIDs = array(	1,
							2,
							3,
							4,
							5,
							6,
							7,
							8,
							9,
							10);

	$latestAlbums = array();
	foreach($latestAlbumIDs as $albumid)
		array_push($latestAlbums, getAlbumWithSongs($albumid));
	
	$latestSongs = array();
	foreach($latestSongIDs as $songid)
		array_push($latestSongs, getSongWithAlbum($songid));


	$result = ["Albums"=>$latestAlbums, "Songs"=>$latestSongs];

	return $result;
}

?>
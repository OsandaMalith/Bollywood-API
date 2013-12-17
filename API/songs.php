<?php
require_once("common.php");


function getSong($songid)
{
	global $link;

	$album = $link->prepare("SELECT * FROM songs WHERE SongID=?");
	$album->bind_param("i", $songid);
	$album->execute();

	bindArray($album, $row);
	$album->fetch();

	$album->close();

	if ($row["Singers"] != "")
		$row["Singers"] = json_decode($row["Singers"]);

	$row["Mp3"] = "http://169.254.176.193/jo_bhi_main.mp3?r=".time();

	return $row;
}

function getSongWithAlbum($songid)
{
	global $link;

	$song = getSong($songid);
	
	$song["Album"] = getAlbum($song["AlbumID"]);

	return $song;
}

function getSongsFromAlbum($albumid)
{
	$response = array();
	global $link;

	$songs = $link->prepare("SELECT SongID FROM songs WHERE AlbumID=?");
	$songs->bind_param("i", $albumid);
	$songs->execute();
	$songs->store_result();

	bindArray($songs, $row);
	while($songs->fetch())
		array_push($response, getSong($row["SongID"]));

	$songs->free_result();
	$songs->close();

	return $response;
}

function searchSongName($name)
{
	global $link;

	$songs = array();

	$name = $name."%";
	
	$search = $link->prepare("SELECT SongID FROM songs WHERE Name LIKE ? ORDER BY Likes DESC LIMIT 15");
	$search->bind_param("s", $name);
	$search->execute();
	$search->store_result();

	bindArray($search, $row);
	while($search->fetch())
		array_push($songs, getSongWithAlbum($row["SongID"]));

	$search->free_result();
	$search->close();

	return $songs;
}

?>
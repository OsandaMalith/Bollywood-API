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

	$songs = $link->prepare("SELECT * FROM songs WHERE AlbumID=?");
	$songs->bind_param("i", $albumid);
	$songs->execute();

	bindArray($songs, $row);
	while($songs->fetch())
		array_push($response, arrayCopy($row));

	$songs->close();

	return $response;
}

function searchSongName($name)
{
	global $link;

	$songs = array();

	$name = $name."%";
	
	$search = $link->prepare("SELECT SongID FROM songs WHERE Name LIKE ? OR Name SOUNDS LIKE ? ORDER BY Likes DESC LIMIT 15");
	$search->bind_param("ss", $name, $name);
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
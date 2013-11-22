<?php
require_once("common.php");


function getSong($songid)
{
	global $link;

	$album = $link->prepare("SELECT * FROM songs WHERE SongID=?");
	$album->bind_param("i", $songid);
	$album->execute();

	$result = $album->get_result();
	$row = $result->fetch_array(MYSQLI_ASSOC);
	
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

	$result = $songs->get_result();
	while ($row = $result->fetch_array(MYSQLI_ASSOC))
	{
		array_push($response, $row);
	}

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

	$result = $search->get_result();
	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
		array_push($songs, getSongWithAlbum($row["SongID"]));
	}

	$search->close();

	return $songs;
}

?>
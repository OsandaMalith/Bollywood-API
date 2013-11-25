<?php
require_once("common.php");


function getAlbum($albumid)
{
	global $link;

	$album = $link->prepare("SELECT * FROM albums WHERE AlbumID=?");
	$album->bind_param("i", $albumid);
	$album->execute();

	$result = $album->get_result();
	$row = $result->fetch_array(MYSQLI_ASSOC);
	
	$album->close();

	return $row;
}

function getAlbumWithSongs($albumid)
{
	global $link;

	$album = getAlbum ($albumid);

	$album["Songs"] = getSongsFromAlbum($albumid);

	return $album;
}

function searchAlbumName($name)
{
	global $link;

	$albums = array();

	$name = $name."%";
	
	$search = $link->prepare("SELECT AlbumID FROM albums WHERE Name LIKE ? OR Name SOUNDS LIKE ? ORDER BY Year DESC LIMIT 10");
	$search->bind_param("ss", $name, $name);
	$search->execute();

	$result = $search->get_result();
	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
		array_push($albums, getAlbumWithSongs($row["AlbumID"]));
	}

	$search->close();

	return $albums;
}

?>
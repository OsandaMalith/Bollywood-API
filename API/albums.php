<?php
require_once("common.php");


function getAlbum($albumid)
{
	global $link;

	$album = $link->prepare("SELECT * FROM albums WHERE AlbumID=?");
	$album->bind_param("i", $albumid);
	$album->execute();

	bindArray($album, $row);
	$album->fetch();

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
	$search->store_result();

	bindArray($search, $row);
	while($search->fetch())
		array_push($albums, getAlbumWithSongs($row["AlbumID"]));

	$search->free_result();
	$search->close();

	return $albums;
}

?>
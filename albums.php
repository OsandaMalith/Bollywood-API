<?php
require_once("common.php");


function getAlbum($albumid, $table = "songspk")
{
	global $link;

	$album = $link->prepare("SELECT AlbumID, Name, Cast, MusicDirector, Year, AlbumArt FROM ".$table."_albums WHERE AlbumID=?");
	$album->bind_param("i", $albumid);
	$album->execute();

	bindArray($album, $row);
	$album->fetch();

	$album->close();

	if ($row["Cast"] != "")
		$row["Cast"] = json_decode($row["Cast"]);
	
	if ($row["MusicDirector"] != "")
		$row["MusicDirector"] = json_decode($row["MusicDirector"]);

	$row["Provider"] = $table;
	
	$row = setAlbumArt($row, $table);
	if ($table == "songspk")
		$row = getMappedData($row);
	
	return $row;
}

function setAlbumArt($album, $table)
{
	$album["AlbumArtBig"] = $album["AlbumArt"];
	$album["AlbumArtSmall"] = $album["AlbumArt"];

	if ($table == "dhingana")
	{
		$album["AlbumArtBig"] = str_replace("148", "640", $album["AlbumArt"]);
		$album["AlbumArtSmall"] = str_replace("148", "300", $album["AlbumArt"]);
	}
	else if($table == "saavn")
	{
		$album["AlbumArtBig"] = str_replace("150", "500", $album["AlbumArt"]);
		$album["AlbumArtSmall"] = str_replace("150", "500", $album["AlbumArt"]);
	}

	unset($album["AlbumArt"]);

	return $album;
}

function getMappedData($album)
{
	global $link;

	$map = $link->prepare("SELECT SaavnID FROM map WHERE PKID=?");
	$map->bind_param("i", $album["AlbumID"]);
	$map->execute();
	$map->store_result();
	if ($map->num_rows == 0)
	{	
		$map->close();
		return $album;	
	}
	bindArray($map, $row);
	$map->fetch();
	$saavnid = $row["SaavnID"];
	$map->close();

	$newalbum = getAlbum($saavnid, "saavn");
	$album["Name"] = $newalbum["Name"];
	$album["Cast"] = $newalbum["Cast"];
	$album["Year"] = $newalbum["Year"];
	$album["MusicDirector"] = $newalbum["MusicDirector"];
	$album["AlbumArt"] = $newalbum["AlbumArtSmall"];
	$album["Provider"] = "saavn";
	$album = setAlbumArt($album, "saavn");

	return $album;	
}

function getAlbumWithSongs($albumid, $table = "songspk")
{
	global $link;

	$album = getAlbum ($albumid, $table);

	$album["Songs"] = getSongsFromAlbum($albumid, $table);

	return $album;
}

function searchAlbumNameInAll($name, $isFinal)
{
	$pk = searchAlbumName($name, $isFinal, "songspk");
	if (count($pk) == 0)
		return searchAlbumName($name, $isFinal, "dhingana");
	else
		return $pk;
}

function searchAlbumName($name, $isFinal, $table = "songspk")
{
	global $link;
	
	$albums = array();

	$fuzzy = "damlev(Name, ?)";
	if ($isFinal)
	{
		$query = "SELECT AlbumID FROM ".$table."_albums WHERE $fuzzy <= 4 ORDER BY $fuzzy ASC LIMIT 10";
		$search = $link->prepare($query);
		$search->bind_param("ss", $name, $name);
	}
	else
	{
		$startWith = $name."%"; 
		$query = "SELECT AlbumID FROM ".$table."_albums WHERE $fuzzy <=2 OR Name Like ? LIMIT 10";	
		$search = $link->prepare($query);
		$search->bind_param("ss", $name, $startWith);
	}
	$search->execute();
	$search->store_result();

	bindArray($search, $row);
	while($search->fetch())
		array_push($albums, getAlbumWithSongs($row["AlbumID"], $table));

	$search->free_result();
	$search->close();

	return $albums;
}

?>

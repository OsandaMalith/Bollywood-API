<?php
require_once("common.php");


function getSong($songid, $table = "songspk")
{
	global $link;

	$song = $link->prepare("SELECT SongID,AlbumID,Name,Singers,Mp3 FROM ".$table."_songs WHERE SongID=?");
	$song->bind_param("i", $songid);
	$song->execute();

	bindArray($song, $row);
	$song->fetch();

	$song->close();

	if ($row["Singers"] != "")
		$row["Singers"] = json_decode($row["Singers"]);

	$row["Provider"] = $table;

	return $row;
}

function getSongWithAlbum($songid, $table = "songspk")
{
	global $link;

	$song = getSong($songid, $table);
	
	$song["Album"] = getAlbum($song["AlbumID"], $table);

	return $song;
}

function getSongsFromAlbum($albumid, $table = "songspk")
{
	$response = array();
	global $link;

	$songs = $link->prepare("SELECT SongID FROM ".$table."_songs WHERE AlbumID=?");
	$songs->bind_param("i", $albumid);
	$songs->execute();
	$songs->store_result();

	bindArray($songs, $row);
	while($songs->fetch())
		array_push($response, getSong($row["SongID"], $table));

	$songs->free_result();
	$songs->close();

	return $response;
}

function searchSongNameInAll($name, $isFinal)
{
	$pk = searchSongName($name, $isFinal, "songspk");
	if (count($pk) == 0)
		return searchSongName($name, $isFinal, "dhingana");
	else
		return $pk;
}

function searchSongName($name, $isFinal, $table = "songspk")
{
	global $link;

	$songs = array();

	$fuzzy = "damlev(Name, ?)";	
        if ($isFinal)
        {
                $query = "SELECT SongID FROM ".$table."_songs WHERE $fuzzy <= 4 ORDER BY $fuzzy ASC LIMIT 10";
                $search = $link->prepare($query);
                $search->bind_param("ss", $name, $name); 
	}
        else
        {
                $startWith = $name."%";
                $query = "SELECT SongID FROM ".$table."_songs WHERE $fuzzy <=2 OR Name Like ? LIMIT 10";   
                $search = $link->prepare($query);
                $search->bind_param("ss", $name, $startWith);
        }
	$search->execute();
	$search->store_result();

	bindArray($search, $row);
	while($search->fetch())
		array_push($songs, getSongWithAlbum($row["SongID"], $table));

	$search->free_result();
	$search->close();

	return $songs;
}

?>

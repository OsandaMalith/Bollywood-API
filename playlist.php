<?php
require_once("common.php");


function createEmptyPlaylist($userid)
{
	global $link;

	$emptyArray = "[]";
	$playlist = $link->prepare("INSERT INTO playlists (UserID, SongIDs) VALUES (?,?)");
	$playlist->bind_param("is", $userid, $emptyArray);
	$playlist->execute();
	$playlist->close();
}

function getPlaylist()
{
	global $link;

	$response = array();
	$userid = $_SESSION["userid"];

	$playlist = $link->prepare("SELECT * FROM playlists WHERE UserID=?");
	$playlist->bind_param("i", $userid);
	$playlist->execute();

	bindArray($playlist, $row);
	$playlist->fetch();
	
	$songids = json_decode($row["SongIDs"]);

	$playlist->close();


	foreach($songids as $songid)
	{
		$song = getSongWithAlbum($songid);
		array_push($response, $song);
	}

	return $response;
}


function updatePlaylistWithSongIDs($songids)
{
	global $link;
	$userid = $_SESSION["userid"];

	$update = $link->prepare("UPDATE playlists SET SongIDs=? WHERE UserID=?");
	$update->bind_param("si", $songids, $userid);
	$update->execute();
	$update->close();
}

?>
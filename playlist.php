<?php
require_once("common.php");


function createEmptyPlaylist()
{
	global $link;

	$userid = $_SESSION["userid"];

	$emptyArray = "[]";
	$playlist = $link->prepare("INSERT INTO music.playlists (UserID, SongIDs) VALUES (?,?)");
	$playlist->bind_param("is", $userid, $emptyArray);
	$playlist->execute();
	$playlist->close();
}

function getPlaylist()
{
	global $link;

	$response = array();
	$userid = $_SESSION["userid"];

	$playlist = $link->prepare("SELECT * FROM music.playlists WHERE UserID=?");
	$playlist->bind_param("i", $userid);
	$playlist->execute();

	$result = $playlist->get_result();
	$row = $result->fetch_array(MYSQLI_ASSOC);
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

	$update = $link->prepare("UPDATE music.playlists SET SongIDs=? WHERE UserID=?");
	$update->bind_param("si", $songids, $userid);
	$update->execute();
	$update->close();
}

?>
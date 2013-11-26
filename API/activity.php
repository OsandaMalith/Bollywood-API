<?php
require_once("common.php");


function postActivityData($userid, $data)
{
	global $link;

	foreach($data as $activity)
	{
		$put = $link->prepare("INSERT INTO activity (UserID, SongID, Type, `Timestamp`) VALUES (?,?,?,?)");
		$put->bind_param("iisi", $userid, $activity["SongID"], $activity["Type"], $activity["Timestamp"]);
		$put->execute();
		$put->close();
	}
}

function getUserActivity($userid)
{
	global $link;

	$activity = array();

	$get = $link->prepare("SELECT ActivityID, SongID, Type, `Timestamp` FROM activity WHERE UserID=?");
	$get->bind_param("i", $userid);
	$get->execute();

	bindArray($get, $row);
	while($get->fetch())
		array_push($activity, $row);

	$get->close();

	return $activity;
}

?>
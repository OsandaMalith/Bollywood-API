<?php
require_once("common.php");


function postActivityData($data)
{
	global $link;

	$userid = $_SESSION["userid"];

	foreach($data as $activity)
	{
		$put = $link->prepare("INSERT INTO activity (UserID, SongID, Type, `Timestamp`) VALUES (?,?,?,?)");
		$put->bind_param("iisi", $userid, $activity["SongID"], $activity["Type"], $activity["Timestamp"]);
		$put->execute();
		$put->close();
	}
}

function getUserActivity()
{
	global $link;

	$userid = $_SESSION["userid"];

	$activity = array();

	$get = $link->prepare("SELECT ActivityID, SongID, Type, `Timestamp` FROM activity WHERE UserID=?");
	$get->bind_param("i", $userid);
	$get->execute();

	$result = $get->get_result();
	while($row = $result->fetch_array(MYSQLI_ASSOC))
	{
		array_push($activity, $row);
	}

	$get->close();

	return $activity;
}

?>
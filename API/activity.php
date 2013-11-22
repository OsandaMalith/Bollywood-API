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

?>
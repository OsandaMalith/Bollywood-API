<?php
require_once("common.php");


function postActivityData($userid, $data)
{
        global $link, $accessLevel;

	if ($accessLevel == 0)
		return;

	if (login($userid) == false)
	{
		message("Login Failed: $userid");
		return;
	}
	
	$partialSuccess = false;
        foreach($data as $activity)
        {
		if (doesActivityExist($userid, $activity) == false)
		{
			$songid = getOriginalID($activity["SongID"]);
			$table = getTable($activity["SongID"]);
			$put = $link->prepare("INSERT INTO activity (UserID, SongID, Action, `Timestamp`, Extra, Provider) VALUES (?,?,?,?,?,?)");
			$put->bind_param("iisiss", $userid, $songid, $activity["Action"], $activity["Timestamp"], $activity["Extra"], $table);
			$put->execute();
			$put->close();
        	}
		else
			$partialSuccess = true;
	}
        
	if ($partialSuccess)
		message("Success-Partial");
	else
        	message("Success");
}

function doesActivityExist($userid, $activity)
{
	global $link;
	$check = $link->prepare("SELECT * FROM activity WHERE UserID=? and `Timestamp`=?");
	$check->bind_param("ii", $userid, $activity["Timestamp"]);
	$check->execute();
	$check->store_result();
	$count = $check->num_rows;
	$check->free_result();
	$check->close();
	if ($count == 0)
		return false;
	return true;
}

function getUserActivity($userid)
{
        global $link;

        $activity = array();

        $get = $link->prepare("SELECT ActivityID, SongID, `Timestamp`, Action, Extra FROM activity WHERE UserID=? LIMIT 20");
        $get->bind_param("i", $userid);
        $get->execute();

        bindArray($get, $row);
        while($get->fetch())
                $activity[] = arrayCopy($row);

        $get->close();

        return $activity;
}
?>

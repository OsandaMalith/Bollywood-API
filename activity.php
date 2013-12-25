<?php
require_once("common.php");


function postActivityData($userid, $data)
{
        global $link;

        foreach($data as $activity)
        {
                $put = $link->prepare("INSERT INTO activity (UserID, SongID, Action, `Timestamp`, Extra) VALUES (?,?,?,?,?)");
                $put->bind_param("iisis", $userid, $activity["SongID"], $activity["Action"], $activity["Timestamp"], $activity["Extra"]);
                $put->execute();
                $put->close();
        }
        
        message("Success");
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

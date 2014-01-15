<?php
require_once("common.php");

class Utility
{
	public static function getInternalID($externalID)
	{
                if (strpos($externalID, "p_") === 0)
                        return str_replace("p_", "", $externalID);
                else if (strpos($externalID, "d_") === 0)
                        return str_replace("d_", "", $externalID);
                else if(strpos($externalID, "s_") === 0)
                        return str_replace("s_", "", $externalID);

	}

	public static function getExternalID($internalID, $table)
	{
		if ($table == "songspk")
                        return "p_".$internalID;
                else if($table == "dhingana")
                        return "d_".$internalID;
                else if($table == "saavn")
                        return "s_".$internalID;
	}

	public static function getTableFromID($externalID)
	{
                if (strpos($externalID, "p_") === 0)
                        return "songspk";
                else if (strpos($externalID, "d_") === 0)
                        return  "dhingana";
                else if(strpos($externalID, "s_") === 0)
                        return "saavn";

	}
}

?>

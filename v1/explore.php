<?php
require_once("common.php");

function getExploreJSON()
{
	$json = json_decode(file_get_contents(dirname(__FILE__)."/../../../data/explore.json"));
	$final_json = array();
	foreach($json->Titles as $title) {
		$albums = array();
		foreach($json->$title as $albumid) {
			$album = new Album($albumid);
			$album->setSongs();	
			array_push($albums, $album);
		}
		$final_json[$title] = $albums;
	}
	$final_json["Titles"] = $json->Titles;
	return $final_json;
}

?>

<?php

if (isset($_GET['fName']))
	$fname = $_GET['fName'];
else if(isset($_POST['fName']))
	$fname = $_POST['fName'];

$link= new mysqli("127.0.0.1", "root", "");
$link->select_db("music-web");

call_user_func($fname);

$link->close();

//139.23.33.27
function getHtml()
{

	$url = $_GET['url'];

	$opts = array( 
	    'http' => array ( 
	        'method'=>'GET', 
	        'proxy'=>'127.0.0.1:9998', 
	        'request_fulluri' => true, 
	    )
	); 
	$ctx = stream_context_create($opts); 
	$content = file_get_contents("$url",false,$ctx); 

	echo $content; 
}

function doesExist($url)
{
	global $link;

	$toReturn = false;

	$duplicate = $link->prepare("SELECT AlbumID FROM albums WHERE URL=?");
	$duplicate->bind_param("s", $url);
	$duplicate->execute();
	$duplicate->store_result();
	
	if ($duplicate->num_rows==0)
		$toReturn = false;
	else
		$toReturn = true;

	$duplicate->close();

	return $toReturn;
}

function saveAlbum()
{
	$album = $_POST["album"];
	$album["cast"] = json_encode($album["cast"]);
	$album["musicDirector"] = json_encode($album["musicDirector"]);

	global $link;

	if (!doesExist($album["url"]))
	{
		$save = $link->prepare("INSERT INTO albums (URL, AlbumArt, Name, Cast, MusicDirector, Year) VALUES (?,?,?,?,?,?)");
		$save->bind_param("sssssi", $album["url"], $album["albumArt"], $album["name"], $album["cast"], $album["musicDirector"], $album["year"]);
		$save->execute();
		$albumid = $save->insert_id;
		$save->close();

		foreach($album["songs"] as $dhinganaId)
		{
			$dhinganaId = intval($dhinganaId);
			$song = $link->prepare("INSERT INTO songs (AlbumID, DhinganaID) VALUES (?,?)");
			$song->bind_param("ii", $albumid, $dhinganaId);
			$song->execute();
			$song->close();
		}

	}
}

?>
<?php

if (isset($_GET['fName']))
	$fname = $_GET['fName'];
else if(isset($_POST['fName']))
	$fname = $_POST['fName'];

$link= new mysqli("127.0.0.1", "root", "mysql");
$link->select_db("music-web");

call_user_func($fname);

$link->close();

function getHtml()
{
	$url = $_GET['url'];

	$desktop = "User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.63 Safari/537.36";
	$mobile = "User-Agent: Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_0 like Mac OS X; en-us) AppleWebKit/532.9 (KHTML, like Gecko) Version/4.0.5 Mobile/8A293 Safari/6531.22.7";

	$isMobile = (isset($_GET["isMobile"]) && $_GET["isMobile"] == "YES");

	$opts = array( 
	    'http' => array ( 
	        'method'=>'GET', 
	        'proxy'=>'127.0.0.1:9996', 
	        'request_fulluri' => true,
	        'header' =>  ($isMobile) ? $mobile : $desktop
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

function saveData()
{
	$album = $_POST["album"];

	if (isset($album["cast"]))
		$album["cast"] = json_encode($album["cast"]);
	else
		$album["cast"] = "";

	if (isset($album["musicDirector"]))
		$album["musicDirector"] = json_encode($album["musicDirector"]);
	else
		$album["musicDirector"] = "";

	global $link;

	if (!doesExist($album["url"]))
	{
		$save = $link->prepare("INSERT INTO albums (URL, AlbumArt, Name, Cast, MusicDirector, Year, Category) VALUES (?,?,?,?,?,?,?)");
		$save->bind_param("sssssis", $album["url"], $album["albumArt"], $album["name"], $album["cast"], $album["musicDirector"], $album["year"], $album["category"]);
		$save->execute();
		$albumid = $save->insert_id;
		$save->close();

		if (isset($album["songs"]))
		{
			foreach($album["songs"] as $song)
			{
				$songQ = $link->prepare("INSERT INTO songs (AlbumID, DhinganaID, Name, Singers, Size, Duration, Mp3, Likes, Dislikes, Favorites) VALUES (?,?,?,?,?,?,?,?,?,?)");
				$songQ->bind_param("iissiisiii", $albumid, $song["Id"], $song["Name"], $song["Singers"], $song["Size"], $song["Duration"], $song["Streams"]["Mp3"], $song["Likes"], $song["Dislikes"], $song["Favorites"]);
				$songQ->execute();
				$songQ->close();
			}
		}
		echo "Saved ".$album["name"]."";
	}
	else
		echo "Skipped ".$album["name"]."";
}

?>
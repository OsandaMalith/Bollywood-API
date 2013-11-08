<?php

if (isset($_GET['fName']))
	$fname = $_GET['fName'];
else if(isset($_POST['fName']))
	$fname = $_POST['fName'];

$link= new mysqli("127.0.0.1", "root", "");
$link->select_db("music");

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

function saveAlbums()
{
	global $link;

	$albums = $_POST["albums"];
	foreach($albums as $album)
	{
		if (isset($album["Images"]))
			$images = json_encode($album["Images"]);
		else
			$images = "";

		$q = "INSERT INTO music.albums (AlbumID,Name,Type,Genre,Likes,Favorites,AlbumArt,URL) VALUES (?,?,?,?,?,?,?,?)";
		$q = "$q ON DUPLICATE KEY UPDATE Name=?,Type=?,Genre=?,Likes=?,Favorites=?,AlbumArt=?";

		$save = $link->prepare($q);
		$save->bind_param("isssiisssssiis", $album["Id"], $album["Name"], $album["Type"], $album["Genre"], $album["Likes"], $album["Favorites"], $images, $album["Url"], $album["Name"], $album["Type"], $album["Genre"], $album["Likes"], $album["Favorites"], $images);
		$save->execute();
		$save->close();

	}
}

function saveSongs()
{
	global $link;

	$songs = $_POST["songs"];

	foreach($songs as $song)
	{
		if (isset($song["Singers"]))
			$singers = json_encode($song["Singers"]);
		else
			$singers = "";

		$q = "INSERT INTO music.songs (SongID,AlbumID,Name,Singers,Likes,Dislikes,Favorites,Mp3) VALUES (?,?,?,?,?,?,?,?)";
		$q = "$q ON DUPLICATE KEY UPDATE AlbumID=?,Name=?,Singers=?,Likes=?,Dislikes=?,Favorites=?,Mp3=?";

		$save = $link->prepare($q);
		$save->bind_param("iissiiisissiiis", $song["Id"], $song["Album"]["Id"], $song["Name"], $singers, $song["Likes"], $song["Dislikes"], $song["Favorites"], $song["Streams"]["Mp3"], $song["Album"]["Id"], $song["Name"], $singers, $song["Likes"], $song["Dislikes"], $song["Favorites"], $song["Streams"]["Mp3"]);
		$save->execute();
		$save->close();
	}
}

?>

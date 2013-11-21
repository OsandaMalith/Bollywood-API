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

		$q = "INSERT INTO music.albums (AlbumID,Name,Type,Genre,Likes,Favorites,AlbumArt,URL) VALUES (?,?,?,?,?,?,?,?)";
		//$q = "$q ON DUPLICATE KEY UPDATE Name=?,Type=?,Genre=?,Likes=?,Favorites=?,AlbumArt=?";

		$save = $link->prepare($q);
		//$save->bind_param("isssiisssssiis", $album["Id"], $album["Name"], $album["Type"], $album["Genre"], $album["Likes"], $album["Favorites"], $album["Images"], $album["Url"], $album["Name"], $album["Type"], $album["Genre"], $album["Likes"], $album["Favorites"], $album["Images"]);
		$save->bind_param("isssiiss", $album["Id"], $album["Name"], $album["Type"], $album["Genre"], $album["Likes"], $album["Favorites"], $album["Images"], $album["Url"]);
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
		$q = "INSERT INTO music.songs (SongID,AlbumID,Name,Singers,Likes,Dislikes,Favorites,Mp3,Size,Duration) VALUES (?,?,?,?,?,?,?,?,?,?)";
		//$q = "$q ON DUPLICATE KEY UPDATE AlbumID=?,Name=?,Singers=?,Likes=?,Dislikes=?,Favorites=?,Mp3=?";

		$save = $link->prepare($q);
		//$save->bind_param("iissiiisissiiis", $song["Id"], $song["Album"]["Id"], $song["Name"], $song["Singers"], $song["Likes"], $song["Dislikes"], $song["Favorites"], $song["Streams"]["Mp3"], $song["Album"]["Id"], $song["Name"], $song["Singers"], $song["Likes"], $song["Dislikes"], $song["Favorites"], $song["Streams"]["Mp3"]);
		$save->bind_param("iissiiisii", $song["Id"], $song["Album"]["Id"], $song["Name"], $song["Singers"], $song["Likes"], $song["Dislikes"], $song["Favorites"], $song["Streams"]["Mp3"], $song["Size"], $song["Duration"]);
		$save->execute();
		$save->close();
	}
}

?>

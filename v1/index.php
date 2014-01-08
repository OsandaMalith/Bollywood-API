<?php
require_once("common.php");

require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();
$app->response->headers->set('Content-Type', 'application/json');

$app->get('/', function () {
 	message("Hello World!"); 	
 });

$app->get("/albums/:albumid", function($albumid) {
	echo json_encode(getAlbum($albumid));
});

$app->get("/albums/:albumid/songs", function($albumid) {
	echo json_encode(getAlbumWithSongs($albumid));
});

$app->get("/songs/:songid", function($songid) {
	echo json_encode(getSong($songid));
});

$app->get("/songs/:songid/album", function($songid) {
	echo json_encode(getSongWithAlbum($songid));
});

$app->get("/search/albums/:name", function($name) {
	echo json_encode(searchAlbumNameInAll($name, true));
});

$app->get("/search/like/albums/:name", function($name) {
	echo json_encode(searchAlbumNameInAll($name, false));
});

$app->get("/search/songs/:name", function($name) {
	echo json_encode(searchSongNameInAll($name, true));
});

$app->get("/search/like/songs/:name", function($name) {
	echo json_encode(searchSongNameInAll($name, false));
});

$isValid = validateRequest($app->request->get("DeveloperID"), 
				$app->request->get("Timestamp"), 
				$app->request->headers->get("Authentication"));

if ($isValid == true)
	$app->run();

?>

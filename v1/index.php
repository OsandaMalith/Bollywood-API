<?php
require_once("common.php");

require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();

$accessLevel = 0;

$app = new \Slim\Slim();
$app->response->headers->set('Content-Type', 'application/json');

$app->get('/', function () {
 	message("Hello World!"); 	
 });

$app->get("/album/:albumid", function($albumid) {
	echo json_encode(getAlbum($albumid));
});

$app->get("/album/:albumid/songs", function($albumid) {
	echo json_encode(getAlbumWithSongs($albumid));
});

$app->get("/song/:songid", function($songid) {
	echo json_encode(getSong($songid));
});

$app->get("/song/:songid/album", function($songid) {
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
				$app->request->get("hmac"));

if ($isValid == true)
	$app->run();

?>
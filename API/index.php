<?php
require_once("common.php");

require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();
$app->response->headers->set('Content-Type', 'application/json');

$app->get('/', function () {
 	message("Hello World!"); 	
 });

$app->get('/user/create', function() {
	createNewUser();
});

$app->post('/user/login', function() {
	global $app;
	$credentials = json_decode($app->request->getBody());
	login($credentials->userid, $credentials->password);
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

$app->get("/playlist", function() {
	echo json_encode(getPlaylist());
});

$app->post("/playlist", function() {
	global $app;
	$songids = $app->request->getBody();
	updatePlaylistWithSongIDs($songids);
});

$app->get("/search/albums/:name", function($name) {
	echo json_encode(searchAlbumName($name));
});

$app->get("/search/songs/:name", function($name) {
	echo json_encode(searchSongName($name));
});

$app->run();

?>
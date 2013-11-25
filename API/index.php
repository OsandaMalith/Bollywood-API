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
	global $app;
	$app->etag('0000');
	echo json_encode(getAlbum($albumid));
});

$app->get("/albums/:albumid/songs", function($albumid) {
	global $app;
	$app->etag('0000');
	echo json_encode(getAlbumWithSongs($albumid));
});

$app->get("/songs/:songid", function($songid) {
	global $app;
	$app->etag('0000');
	echo json_encode(getSong($songid));
});

$app->get("/songs/:songid/album", function($songid) {
	global $app;
	$app->etag('0000');
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
	global $app;
	$app->etag('0000');
	echo json_encode(searchAlbumName($name));
});

$app->get("/search/songs/:name", function($name) {
	global $app;
	$app->etag('0000');
	echo json_encode(searchSongName($name));
});

$app->get("/activity", function() {
	echo json_encode(getUserActivity());
});

$app->post("/activity", function() {
	global $app;
	$activityData = json_decode($app->request->getBody(), true);
	postActivityData($activityData);
});

//sleep((mt_rand()%5) + 1);

$app->run();

?>
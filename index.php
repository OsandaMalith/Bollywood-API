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
	echo json_encode(createNewUser());
});

$app->get("/user/:userid/activity", function($userid) {
	echo json_encode(getUserActivity($userid));
});

$app->post("/user/:userid/activity", function($userid) {
	global $app;
	$activityData = json_decode($app->request->getBody(), true);
	postActivityData($userid, $activityData["data"]);
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

$app->get("/explore", function() {	
	echo json_encode(getExploreAll());
});

/*
$app->get("/playlist", function() {
	echo json_encode(getPlaylist());
});

$app->post("/playlist", function() {
	global $app;
	$songids = $app->request->getBody();
	updatePlaylistWithSongIDs($songids);
});

$app->post('/user/login', function() {
	global $app;
	$credentials = json_decode($app->request->getBody());
	
	if (login($credentials->userid, $credentials->password))
		message("success");
	else
		message("failed");
});
*/

//sleep((mt_rand()%3) + 1);

$app->run();

?>

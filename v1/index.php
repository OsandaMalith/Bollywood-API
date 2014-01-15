<?php
require_once("common.php");

require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();
$app->response->headers->set('Content-Type', 'application/json');

$app->get('/', function () {
 	message("Hello World!"); 	
 });

$app->get("/test", function() {
//	$album = new Album("p_3228");
//	$album->setSongs();
//	echo json_encode($album);

//	$albums = Album::albumsFromArray(array("p_1", "p_2"));
//	foreach($albums as $album)
//		$album->setSongs();
//	echo json_encode($albums);

//	$song = new Song("p_22403");
//	echo json_encode($song);

//	$songs = Song::songsFromArray(array("p_22403", "p_22404"));
//	foreach($songs as $song)
//		$song->setAlbum();
//	echo json_encode($songs);

	$search = new Search("taal", false);
	echo json_encode($search->albums());
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

$app->get("/explore", function() {
        echo json_encode(getExploreAll());
});

class ValidationMiddleware extends \Slim\Middleware
{
	public function call()
	{
		$app = $this->app;
		$isValid = validateRequest(	$app->request->get("DeveloperID"), 
						$app->request->get("Timestamp"), 
						$app->request->get("hmac"));

		if ($isValid == true)
			$this->next->call();
	}
}

$accessLevel = 1;
//$app->add(new \ValidationMiddleware());
$app->run();

?>

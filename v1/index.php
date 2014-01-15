<?php
require_once("common.php");

require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();
$app->response->headers->set('Content-Type', 'application/json');

$app->get('/', function () {
	Utility::json("Hello World"); 	
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

	$search = new Search("jo bhi main", true);
	echo json_encode($search->songs());
});

$app->get("/album/:albumid", function($albumid) {
	echo json_encode(new Album($albumid));
});

$app->get("/album/:albumid/songs", function($albumid) {
	$album = new Album($albumid);
	$album->setSongs();
	echo json_encode($album);
});

$app->get("/song/:songid", function($songid) {
	echo json_encode(new Song($songid));
});

$app->get("/song/:songid/album", function($songid) {
	$song = new Song($songid);
	$song->setAlbum();
	echo json_encode($song);
});

$app->get("/search/albums/:name", function($name) {
	$search = new Search($name, true);
	echo json_encode($search->albums());
});

$app->get("/search/like/albums/:name", function($name) {
	$search = new Search($name, false);
	echo json_encode($search->albums());
});

$app->get("/search/songs/:name", function($name) {
	$search = new Search($name, true);
	echo json_encode($search->songs());
});

$app->get("/search/like/songs/:name", function($name) {
	$search = new Search($name, false);
	echo json_encode($search->songs());
});

$app->get('/user/create', function() {
        echo json_encode(User::create());
});

$app->post("/user/:userid/activity", function($userid) {
        global $app;

	$user = new User;
	$user->setUserid($userid);
	$activities = json_decode($app->request->getBody(), true);
	foreach ($activites as $data)
	{
		$activity = new Activity($user, $data);
		$activity->save();
	}
});

$app->get("/explore", function() {
        echo json_encode(new Explore);
});

class ValidationMiddleware extends \Slim\Middleware
{
	public function call()
	{
		$app = $this->app;
		$isValid = Utility::validateRequest(	$app->request->get("DeveloperID"), 
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

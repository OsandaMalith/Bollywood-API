<?php
require_once("common.php");

require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();
$app->response->headers->set('Content-Type', 'application/json');

$app->get('/', function () {
	Utility::json("Hello World"); 	
});

$app->get("/album/:albumid", function($albumid) use ($app){
	Utility::setCacheHeaders($app);
	echo json_encode(new Album($albumid));
});

$app->get("/album/:albumid/songs", function($albumid) use ($app){
	Utility::setCacheHeaders($app);
	$album = new Album($albumid);
	$album->setSongs();
	echo json_encode($album);
});

$app->get("/song/:songid", function($songid) use ($app){
	Utility::setCacheHeaders($app);
	echo json_encode(new Song($songid));
});

$app->get("/song/:songid/album", function($songid) use ($app){
	Utility::setCacheHeaders($app);
	$song = new Song($songid);
	$song->setAlbum();
	echo json_encode($song);
});

$app->get("/search/albums/:name", function($name) use ($app){
	Utility::setCacheHeaders($app);
	$search = new Search($name, true);
	echo json_encode($search->albums());
});

$app->get("/search/like/albums/:name", function($name) use ($app) {
	Utility::setCacheHeaders($app);
	$search = new Search($name, false);
	echo json_encode($search->albums());
});

$app->get("/search/songs/:name", function($name) use ($app) {
	Utility::setCacheHeaders($app);
	$search = new Search($name, true);
	echo json_encode($search->songs());
});

$app->get("/search/like/songs/:name", function($name) use ($app) {
	Utility::setCacheHeaders($app);
	$search = new Search($name, false);
	echo json_encode($search->songs());
});

$app->get('/user/create', function() {
        echo json_encode(User::create());
});

$app->post("/user/:userid/pushtoken", function ($userid) {
	global $app;
	$user = new User;
	$user->setUserid($userid);
	$token = json_decode($app->request->getBody());
	$user->pushToken = $token->PushToken;
	$user->save();
	Utility::json("success");
});

$app->post("/user/:userid/activity", function($userid) {
        global $app;
	$user = new User;
	$user->setUserid($userid);
	$activities = json_decode($app->request->getBody(), true);
	foreach ($activities["data"] as $data)
	{
		$activity = new Activity($user, $data);
		$activity->save();
	}
	Utility::json("success");
});

$app->get("/explore", function() use ($app) {
	Utility::setCacheHeaders($app);
        echo json_encode(new Explore);
});

class ValidationMiddleware extends \Slim\Middleware
{
	public function call()
	{
		global $version, $accessLevel;
		$app = $this->app;
		/*REMOVE WHEN 1.0 IS NOT USED ANYMORE*/
		if ($app->request->get("Version") == NULL && $app->request->get("DeveloperID") == "3f5f40c8")
		{
			$isValid = true;
			$accessLevel = 1;
		}
		else
		{
			$version = $app->request->get("Version");
			$isValid = false;
		}
		if (!$isValid)
		/*-----------------------------------*/
		$isValid = Utility::validateRequest(	$app->request->get("DeveloperID"), 
							$app->request->headers->get("hmac"));

		if ($isValid == true)
			$this->next->call();
	}
}
$accessLevel = 1;
$version = "1.0";
//$app->add(new \ValidationMiddleware());
$app->run();

?>

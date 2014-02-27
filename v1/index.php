<?php
require_once("common.php");

require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();
$app->config('debug', false);
$app->response->headers->set('Content-Type', 'application/json');

$app->error(function(\Exception $e) {
	$error = array(
		"Slim"=>true,
		"Number"=>$e->getCode(),
		"Message"=>$e->getMessage(),
		"File"=>$e->getFile(),
		"Line"=>$e->getLine()
	);
	$error = json_encode(["Error"=>$error]);
	Utility::sendMessage("tusharsoni1205@gmail.com", "Error", $error);
	Utility::json("Error");
});

$app->notFound(function () use ($app) {
	$error = array(
		"Slim"=>true,
		"Number"=>404,
		"Message"=>$app->request->getPath()." not found",
	);
	$error = json_encode(["Error"=>$error]);
	Utility::sendMessage("tusharsoni1205@gmail.com", "Error", $error);
	Utility::json("Error");
});

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
	global $app;
	$analytics_url = "http://analytics.filmiapp.com/api/";
	$app->response->redirect($analytics_url."user/create", 301);
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
$accessLevel = 0;
$version = "1.0";
$app->add(new \ValidationMiddleware());
$app->run();

?>

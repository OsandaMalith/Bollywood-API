<?php
require_once("common.php");

call_user_func($_GET["call"]);

function signup()
{
	createDeveloper($_GET["email"]);
}

function search()
{
	echo json_encode(searchAlbumNameInAll($_GET["name"], true));
}

?>
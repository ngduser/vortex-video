<?php

/*
	player.php
	/srv/Sites/Vortex/html/php/player.php
	Nathan Denig
	nathan@denig.me

	player.php builds the dynamic player page with the VideoPlayer.php class
*/

	include("VideoPlayer.php");
	require("header.php");

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	//Get specified video id
	$video_id = $_SERVER['PATH_INFO'];
	$video_id = trim ($video_id , '/');

	//Use video id for static function to return page html
	$vplayer = VideoPlayer::startPlayer($video_id);

	echo $vplayer;

	require("footer.php");

?>



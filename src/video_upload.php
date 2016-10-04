<?php

/*
	video_upload.php
	/srv/Sites/Vortex/html/php/video_upload.php
	Nathan Denig
	nathan@denig.me

	video_upload.php is called upon by the upload.html web page and creates an instance of the VideoUpload.php class using user specified information and returns Video ID for player.php
*/
	//Set Error Reporting
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	include("VideoUpload.php");

  	//Creates instance of VideoUpload to upload and process the video
  	$video = new VideoUpload($_FILES["uploaded_video"]["tmp_name"], $_FILES["uploaded_video"]["name"]);

	//Get Video ID from uploaded video and go to the player page
	$vid = $video->getVid();

	echo $vid;
	if (isset($vid)) {
		header("Location: http://www.videovortex.stream/php/player.php/$vid");
	}
	else {
		echo "error";
	}
?>

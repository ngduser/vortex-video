<?php
	//Set Error Reporting
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	
	include("VideoUpload.php");

	$video = new VideoUpload($_FILES["uploaded_video"]["tmp_name"], $_FILES["uploaded_video"]["base_name"]);

//	$video ->video_name = basename($_FILES["uploaded_video"]["name"]);

//$_FILES["uploaded_video"]["tmp_name"]
//$_FILES["uploaded_video"]["name"]


?>
<?php

/*
	live.php
	/srv/Sites/Vortex/html/php/live.php
	Nathan Denig
	nathan@denig.me

	live.php connects to the live RTMP stream based on the key input
*/


	if (isset($_POST['LiveKey'])){
		$livekey = $_POST['LiveKey'];
		$p1 = '<div class="container">' . "\n 	<h2>$livekey</h2>\n";
       	$p2 = '         <video id="live" class="video-js vjs-default-skin" controls preload="auto" width="860" height="420" data-setup=' . "'{" . '"Dispay_option":true}' . "'>\n";
       	$p3 = '			<source src="rtmp://www.videovortex.stream:1935/live/' . $livekey . '" type=' . "'rtmp/mp4'>" . '"' . ">\n 		    \n</video><br><br>";
	}

	else {
		$p1 = '<div class="container form-group">' . "\n" . '     <form enctype="multipart/form-data" form action="" method="post">';
		$p2 = "\n 		 <h1>Please enter the LiveKey here</h1>\n 		<p>(Use test for test stream)</p>\n  		" . '<textarea class="form-control" rows="1" id="LK" name="LiveKey"></textarea><br><br>' . "\n";
		$p3 = '<input type="submit" value="Submit Key" class="btn btn-default btn-" name="submit">';
	}

	$content = $p1 . $p2 . $p3;

	//Outputs page for user input
	require("header.php");

	echo $content;

	require("footer.php"); 
?>
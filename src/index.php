<!Doctype html>
<html>

<head>
    <link rel="stylesheet" href="/lib/bootstrap.min.css"/>
    <link rel="stylesheet" href="/lib/sites.css"/>

	   <title>Video Vortex</title>

</head>
<body>

<div class="container-fluid">

	<nav class="navbar navbar-default navbar-fixed-top">
		<div class="btn-group navbar-right">
        	<a href="/upload.html" class="btn btn-default btn-lg">Upload</a>
        	<a href="#" class="btn btn-default btn-lg">About</a>
        	<a href="#" class="btn btn-default btn-lg">Contact</a>
	</nav>
</div>
<div class="jumbotron center-text head-theme" style="background-image: url(/lib/d_cloud.gif); height:750px">
        <div style="position: absolute; top: 40%; left:35%"> 
	<h1>Video Vortex<h1>
        <p>Video Streaming Content Management and Delivery</p>
	</div>
</div>
<?php

/*
	index.php
	/srv/Sites/Vortex/html/php/index.php
	Nathan Denig
	nathan@denig.me

	index.php is the main page of the site and uses the database to dynamically generate the video selections which are linked to player.php
*/
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	//More variable sepecifies which sequential row to start populating
	if (isset($_GET['More'])) {
	    $starting_row = $_GET['More'];
	}

	else {
	    $starting_row = 0;
	}

	$connection = new mysqli("localhost", "vortex", "testpassword", "Vortex");

	if ($connection->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	    echo "error";
	}

	else {
		$result =  $connection->query("SELECT ID, UUID, Ext, Title FROM VideoData LIMIT $starting_row,20");

		$vid_array = array();
		while ($row = mysqli_fetch_array($result)) {
			$vid_array[] = $row;
		}

		//Builders for html site structure
		$filepath = 'http://www.videovortex.stream/php/player.php/';
		$imagepath = 'https://s3-us-west-2.amazonaws.com/vortex-bucket/';
		$builder_start = '<div class="container"> <div class="row">';
		$builder_end = '</div>';
		$builder_row = '<div class="row">';
		$builder_1 = '<div class="col-lg-4 col-sm-5 col-xs-6"> <a href="';
		$builder_2 = '" class="thumbnail-attr"> <img src="';
		$builder_3 = '.jpg" class="img-responsive"> </a> <h3>';
		$builder_4 = '</h3> </div>';
		$builder_newline = "\n";

		$i = 0;
		$id = "ID";
		$title = "Title";
		$uuid = "UUID";
		$ext = "Ext";

		echo $builder_start;
		foreach ($vid_array as $key => $value) {
			echo $builder_newline, $builder_1, $filepath, $value[$id], $builder_2, $imagepath, $value[$uuid], $builder_3, $value[$title], $builder_4, $builder_newline;
		}

		echo $builder_end, $builder_newline;
		
		mysqli_close($connection);

		//Set starting row for next page
		if (count($vid_array < 19)) {
			$starting_row = 0;
		}
		
		else {
			$starting_row = $starting_row + 20;
		}

	}
	echo "<form action='index.php' method='get'>
	<button name='More' type='submit' value='$starting_row' style='border: none; background: none; padding: 0;'><h2>More</h2></button>";
?>
	<script src='/lib/jquery.min.js'> </script>
	<script src='/lib/bootstrap.min.js'> </script>
</body>
</html>




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
        	<a href="#" class="btn btn-default btn-lg">Upload</a>
        	<a href="#" class="btn btn-default btn-lg">About</a>
        	<a href="#" class="btn btn-default btn-lg">Contact</a>
	</nav>
<div>
<div class="jumbotron center-text head-theme" style="background-image: url(/lib/vortex_header.png);">
    	<h1>Video Vortex</h1>
    	<p>Video Streaming Content Management and Delivery</p>
</div>

<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	if (isset($_GET['More'])) {
	    $starting_row = $_GET['More'];
	}

	else {
	    $starting_row = 0;
	}

	$connection = new mysqli("localhost", "vortex", "testpassword", "vigilant");

	if ($connection->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}

	else {
		$result =  $connection->query("SELECT vid_filepath, tn_id, name FROM Video LIMIT $starting_row,20");

		$vid_array = array();

		while ($row = mysqli_fetch_array($result)) {
			$vid_array[] = $row;
		}

		$builder_start = '<div class="container"> <div class="row">';
		$builder_end = '</div>';
		$builder_row = '<div class="row">';
		$builder_1 = '<div class="col-lg-3 col-sm-4 col-xs-6"> <a href="';
		$builder_2 = '" class="thumbnail-attr"> <img src="';
		$builder_3 = '" class="img-responsive"> </a> <h3>';
		$builder_4 = '</h3> </div>';

		$builder_newline = "\n";

		$i = 0;
		$tn_id = "tn_id";
		$name = "name";
		$vid_filepath = "vid_filepath";

		echo $builder_start;
		foreach ($vid_array as $key => $value) {
			echo $builder_newline, $builder_1, $value[$vid_filepath], $builder_2, $value[$tn_id], $builder_3, $value[$name], $builder_4, $builder_newline;
		}

		echo $builder_end, $builder_newline;

		if (count($vid_array < 20)) {
			$starting_row = 0;
		}

		else {
			$starting_row = $starting_row + 5;
		}

	}
	
	echo "<form action='index.php' method='get'>
	<button name='More' type='submit' value='$starting_row' style='border: none; background: none; padding: 0;'><h2>More</h2></button>";
	mysqli_close($connection);
?>
	<script src='/lib/jquery.min.js'> </script>
	<script src='/lib/bootstrap.min.js'> </script>
</body>
</html>




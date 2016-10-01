<!Doctype html>
<html>
<head>
    <title>Video Vortex</title>

    <link rel="stylesheet" href="/lib/bootstrap.min.css"/>
    <link rel="stylesheet" href="/lib/sites.css"/>

    <link href="http://www.videovortex.stream/webapp/video.js/dist/video-js.css" rel="stylesheet">
    <script src="http://www.videovortex.stream/webapp/video.js/dist/video.js"></script>

    <script>
    	videojs.options.flash.swf= "http://www.videovortex.stream/webapp/video.js/dist/video-js.swf"
    </script>
</head>
<body>
<div class="container-fluid">
	<nav class="navbar navbar-default navbar-fixed-top">
		<div class="btn-group navbar-right">
        	<a href="/upload.html" class="btn btn-default btn-lg">Upload</a>
        	<a href="#" class="btn btn-default btn-lg">About</a>
        	<a href="#" class="btn btn-default btn-lg">Contact</a>
		</div>
	</nav>
</div>
<div class="jumbotron center-text head-theme" style="background-image: url(/lib/d_cloud.gif);">
    	<h1>Video Vortex</h1>
    	<p>Video Streaming Content Management and Delivery</p>
</div>

<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);


	$video_id = $_SERVER['PATH_INFO'];
	$video_id = trim ($video_id , '/');

	$video_id;
	$conn = new mysqli("localhost", "vortex", "testpassword", "Vortex");
	if ($conn->connect_error) {
    		die("Connection failed: " . $conn->connect_error);
	}
	else {
		$result = $conn->query("SELECT * from VideoData where ID=$video_id");
		$result_arr = $result->fetch_array(MYSQLI_ASSOC);

		if (is_null($result_arr)) {
			echo "ERROR WITH ID";
		}

		else {
			$title = $result_arr['Title'];
			$uuid = $result_arr['UUID'];
			$ext = $result_arr['Ext'];
			$des = $result_arr['Description'];
			$duration = $result_arr['Duration'];
			$bitrate = $result_arr['Bitrate'];
			$fname = $result_arr['Name'];
                        $nl = "\n";

			$v = '<div class="container">';
			$v_1 = "\n<h2>$title</h2>\n";
                        $v_2 = '         <video id="';
                        $v_3 = '" class="video-js vjs-default-skin" controls preload="auto" width="860" height="420"';
			$v_4 = "data-setup='{";
                        $v_5 = '"Dispay_option":true}';
                        $v_6 = "'>";
			$v_7 = '         	<source src="rtmp://www.videovortex.stream:1935/playback/';
			$v_8 = " type='rtmp/";
			$z_7 = '		 <source src="https://s3-us-west-2.amazonaws.com/vortex-bucket/';
			$z_8 = " type='video/webm";

			$v_9 = "'>";
                        $v_10 = '"';
			$v_11 = '         </video><br><br>';
			$v_12 = "\n</div>";

			$d_1 = '<div class="container col-md-7 col-md-offset-1 text-left">';
			$d_2 = "     <h3>$des</h3><br><br><br>\n";
			$d_3 = "</div>\n";

			$a_1 = '';
			$a_2 = '	<table style="border: 1px solid black; width:75%">';
			$a_3 = "\n	   <tr>\n	    <th>";
			$a_4 = "Duration</th>\n		<th>File Name</th>\n   	    <th>Bitrate</th>\n	   </tr>";
			$a_5 = "\n	   <tr>\n	    <td>$duration</td>\n	   <td>$fname</td>\n";
			$a_6 = "	  <td>$bitrate</td>\n	    </tr>\n";

			$attr = $a_1 . $nl . $a_2 . $a_3 . $a_4 . $a_5 . $a_6;
			if ($ext == "mkv") {
				echo $v . $v_1 . $attr . $nl . $v_2 . $uuid . $v_3 .  $v_4 . $v_5 . $v_6 . $nl . $z_7 . $uuid . "." . $ext . '"' . $z_8 .  $v_9 . $v_10 . $nl . $v_11 . $v_12 . $nl;
			}
			else {
				echo $v . $v_1 . $attr . $nl . $v_2 . $uuid . $v_3 .  $v_4 . $v_5 . $v_6 . $nl . $v_7 . $uuid . "." . $ext . '"' . $v_8 . $ext .  $v_9 . $v_10 . $nl . $v_11 . $v_12 . $nl;
			}
			echo $nl . $d_1 . $nl . $d_2 . $nl . $d_3;
                }
		mysqli_close($conn);
	}

?>

</body>
</html>


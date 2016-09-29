<!doctype html>

<head>
<title><?php
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
                        $nl = "\n";
                       $builder_1 = '</title>';
                       $builder_2 = '          <link href="http://www.videovortex.stream/webapp/video.js/dist/video-js.css" rel="stylesheet">';
                        $builder_3 = '          <script src="http://www.videovortex.stream/webapp/video.js/dist/video.js"></script>';
                        $builder_4 = '          <script>';
                       $builder_5 = '                  videojs.options.flash.swf= "http://www.videovortex.stream/webapp/video.js/dist/video-js.swf"';
                        $builder_6 = '          </script>';
                        $builder_7 = '</head>';
                       $builder_8 = '<body>';
                         $builder_9 = '          <video id="';
                        $builder_10 = '" class="video-js vjs-default-skin" controls preload="auto" width="860" height="420" ';
			$builder_11 = "data-setup='{";
                        $builder_12 = '"Dispay_option":true}';
                        $builder_13 = "'>";





			$builder_14 = '         <source src="rtmp://www.videovortex.stream:1935/playback/';
			$builder_15 = " type='rtmp/";
			$builder_16 = "'>";
                        $builder_17 = '"';
			$builder_18 = '         </video>';
                       $builder_19 = '</body>';

                  	echo $result_arr['Title'] . $builder_1 . $nl . $builder_2 . $nl .  $builder_3 . $nl . $builder_4 . $nl . $builder_5 . $nl . $builder_6 . $nl . $builder_7 . $nl . $builder_8 . $nl;
                        echo $builder_9 . $result_arr['UUID'] . $builder_10 .  $builder_11 . $builder_12 . $builder_13 . $nl . $builder_14 . $result_arr['UUID'] . "." . $result_arr['Ext'] . '"';
                        echo  $builder_15 . $result_arr['Ext'] . $builder_16 . $builder_17 . $nl . $builder_18 . $nl . $builder_19;
                }
		mysqli_close($conn);
	}

?>
</body>
</html>


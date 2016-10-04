<?php

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

/*
	VideoPlayer.php
	/srv/Sites/Vortex/html/php/VideoPlayer.php
	Nathan Denig
	nathan@denig.me

	VideoPlayer.php is a static class called upon by player.php and looks up the attributes for the video id specified and builds a dynamic html player page
*/

	class VideoPlayer {

		private function __construct() {}

		public static function startPlayer($video_id) {
			if (!is_numeric($video_id)) {
				echo "Error- " . $video_id ;
			}

			//Recieve VideoData entry for chosen video from Vortex db
			$conn = new mysqli("localhost", "vortex", "testpassword", "Vortex");

			if ($conn->connect_error) {
		    		die("Connection failed: " . $conn->connect_error);
		    		echo "error";
			}

			else {
				$result = $conn->query("SELECT * from VideoData where ID=$video_id");
				$result_arr = $result->fetch_array(MYSQLI_ASSOC);

				if (is_null($result_arr)) {
					echo "ERROR WITH ID";
				}
			}

			mysqli_close($conn);
			$vplay = VideoPlayer::buildPlayer($result_arr);

			if (isset($vplay)) {
				return $vplay;
			}

			else {
				echo "error-12";
			}
		}

		//Builds the player html using the extension to determine MIME type
		private static function buildPlayer($result_arr) {
			$title = $result_arr['Title'];
			$uuid = $result_arr['UUID'];
			$ext = $result_arr['Ext'];
			$des = $result_arr['Description'];
			$duration = $result_arr['Duration'];
			$bitrate = $result_arr['Bitrate'];
			$fname = $result_arr['Name'];

            		switch($ext) {
            			case "mkv":
          				$mime = '           <source src="https://s3-us-west-2.amazonaws.com/vortex-bucket/' . $uuid . "." . $ext . '"' . " type='video/webm";
         				break;

            			case "mp4":
            				$mime = '           <source src="rtmp://www.videovortex.stream:1935/playback/' . $uuid . "." . $ext . '"' . " type='rtmp/" . $ext;
            				break;

 	          		case "flv":
        	    			$mime = '           <source src="rtmp://www.videovortex.stream:1935/playback/' . $uuid . "." . $ext . '"' . " type='rtmp/" . $ext;
            				break;

        	    		case "avi":
            				$mime = '	    <source src="https://s3-us-west-2.amazonaws.com/vortex-bucket/' . $uuid . "." . $ext . '"' . " type='video/" . $ext;
            				break;

	            		case 'mov':
        	    			$mime = '	    <source src="https://s3-us-west-2.amazonaws.com/vortex-bucket/' . $uuid . "." . $ext . '"' . " type='video/quicktime";
            				break;

 		      		case "ogg":
            				$mime = '	    <source src="https://s3-us-west-2.amazonaws.com/vortex-bucket/' . $uuid . "." . $ext . '"' . " type='video/" . $ext;
            				break;

     	       			default:
   		    			$mime = "";
           				echo "error";
        	    	}

            		//Builder for video player html
		    	$v = '<div class="container">';
		    	$v_1 = "\n<h2>$title</h2>\n";
            		$v_2 = '         <video id="';
            		$v_3 = '" class="video-js vjs-default-skin" controls preload="auto" width="860" height="420"';
            		$v_4 = "data-setup='{";
            		$v_5 = '"Dispay_option":true}';
            		$v_6 = "'>";
            		$v_7= '"';
	    		$v_8 = '        </video><br><br>';
	    		$v_9 = "\n</div>";

		    	//Builder for description
       		     	$d_1 = '<div class="container col-md-7 col-md-offset-2 text-left">';
	    		$d_2 = "     <h3>$des</h3><br><br><br>\n";
	    		$d_3 = "</div>\n";

		    	//Builder for attributes table
		    	$a_1 = '';
		   	$a_2 = '	<table style="border: 1px solid black; width:75%">';
		    	$a_3 = "\n	    <tr>\n	       <th>";
		    	$a_4 = "Duration</th>\n		   <th>File Name</th>\n   	       <th>Bitrate (kbs)</th>\n	     </tr>";
		    	$a_5 = "\n	     <tr>\n	       <td>$duration</td>\n	       <td>$fname</td>\n";
		    	$a_6 = "	       <td>$bitrate</td>\n	     </tr>\n      </table>\n";
		    	$nl = "\n";

		    	$attr = $a_1 . $nl . $a_2 . $a_3 . $a_4 . $a_5 . $a_6;
		    	$descript = $d_1 . $nl . $d_2 . $nl . $d_3;
	    		$vplay = $v . $v_1 . $attr . $nl . $v_2 . $uuid . $v_3 . $v_4 . $v_5 . $v_6 . $nl . $mime . $v_6 . $v_7 . $nl . $v_8 . $v_9. $nl . $descript;

		    	return ($vplay);
		}
	}
?>

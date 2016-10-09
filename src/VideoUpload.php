<?php

/*
	VideoUpload.php
	/srv/Sites/Vortex/html/php/VideoUpload.php
	Nathan Denig
	nathan@denig.me
	
	VideoUpload.php is the class specification which takes a video file and determines the attributes, creates a thumbnail, uploads the video and thumbnail to an S3 bucket, and updates the database. 
*/
	//Specify AWS SDK for S3 location
	require '/srv/Sites/lib/aws-autoloader.php';
	use Aws\S3\S3Client;

	class VideoUpload {

		//Video attribute variables
		private $duration;
		private $bitrate;
		private $name;
		private $description;
		private $location;
		private $uploaded;
		private $created;
		private $file;
		private $uuid;
		private $title;

		//Variables shared in between methods
		private $ext;
		private $target_file;
		private $bucket;
		private $ffmpeg;
		private $s3Client;

		public function __construct($tmp_name, $name) {

			//S3 Bucket information
			$this->s3Client = S3Client::factory(array(
                        'profile' => 'vigilant',
                        'region'  => 'us-west-2',
                        'version' => 'latest'));

			$this->bucket = 'vortex-bucket';
			$this->tmp_name = $tmp_name;

			//Assign shared variables
			$this->name = $name;
			$this->file = basename($name);
			$this->ffmpeg = "/usr/bin/ffmpeg";

			//Run operation methods
			$this->videoAttributes();
			$this->localUpload();
			$this->preparedSQL();
		}

		//Sanitizes SQL inputs
		private function verifyInput($input) {
			$input = trim($input);
			$input = stripslashes($input);
			$input = htmlspecialchars($input);
			return $input;
		}

		//FFMPEG command determies duration and bitrate, POST data set for description and title, unique id generated
		private function videoAttributes() {
			$command = exec($this->ffmpeg . ' -i ' .  $this->tmp_name .  ' -vstats 2>&1 | grep "Duration\|Audio" ', $output, $return);
			if ($return){
				header("Location:http://www.videovortex.stream/php/error.php/11");
				die();
			}

			$attr_output = implode($output);
			$regex='.*?((?:(?:[0-1][0-9])|(?:[2][0-3])|(?:[0-9])):(?:[0-5][0-9])(?::[0-5][0-9])?(?:\\s?(?:am|AM|pm|PM))?).*?\\d+.*?\\d+.*?\\d+.*?(\\d+)';


			if (preg_match_all ("/".$regex."/is", $attr_output, $match)) {
 					$this->duration = $match[1][0];
     				$this->bitrate = $match[2][0];
			}

			else {
				header("Location:http://www.videovortex.stream/php/error.php/11");
				die();
			}

			$this->description = $this->verifyInput($_POST['description']);
			$this->title = $this->verifyInput($_POST['title']);
			$this->uuid = uniqid();
		}

		//Uploads video file locally in order to upload to S3
		private function localUpload() {
			if (move_uploaded_file($this->tmp_name,  "/tmp/" . $this->file )) {

				$this->makeThumbnail();
				$this->uploadFile();
			}
			else {
				header("Location:http://www.videovortex.stream/php/error.php/21");
				die();
			}
		}

		//Makes thumbnail with name 'uuid'.jpg and uploads it locally
		private function makeThumbnail() {
			$thumb = "/tmp/" . $this->uuid . ".jpg";
			$command = exec($this->ffmpeg . ' -i ' . "\"/tmp/$this->name\"" . ' -ss 5 -y -f mjpeg -s 240x135 -vframes 1 '  . $thumb .' 2>&1', $output, $return);

			if ($return) {
				header("Location:http://www.videovortex.stream/php/error.php/11");
				die();
			}
		}

		//Copies video and thumbnail files to the S3 bucket and deletes local copy
		private function uploadFile() {
			$this->ext = pathinfo("/tmp/" . $this->file,PATHINFO_EXTENSION);
			$keyname = $this->uuid . "." . pathinfo("/tmp/" . $this->file,PATHINFO_EXTENSION);

			//Transfer Local Upload to Bucket
			$filepath = "/tmp/" . $this->file;
         	$video_operation = $this->s3Client->putObject(array(
                'Bucket'       => $this->bucket,
                'Key'          => $keyname,
                'SourceFile'   => $filepath,
                'ContentType'  => 'text/plain',
                'ACL'          => 'public-read',
                'StorageClass' => 'REDUCED_REDUNDANCY',));
			
			$thmb_name = $this->uuid . ".jpg";
			$path = "/tmp/" . $thmb_name;
			
			$thumb_operation = $this->s3Client->putObject(array(
    			'Bucket'       => $this->bucket,
   				'Key'          => $thmb_name,
    		    'SourceFile'   => $path,
    		    'ContentType'  => 'text/plain',
    			'ACL'          => 'public-read',
    			'StorageClass' => 'REDUCED_REDUNDANCY',));
			
			unlink("/tmp/" . $this->name);
			unlink($path);
		}

		//Updates database with uuid, duration, filename, description, bitrate, title, and extension. 
		private function preparedSQL() {
			$connection = new mysqli("localhost", "vortex", "testpassword", "Vortex");
			
			if ($connection->connect_error) {
					header("Location:http://www.videovortex.stream/php/error.php/41");
    				die("Connection failed: " . $connection->connect_error);
    				
			}
			else{
				$connection->query("INSERT INTO VideoData ( UUID, Duration, Name, Description, Bitrate, Title, Ext)
					VALUES ( '$this->uuid', '$this->duration', '$this->name', '$this->description', '$this->bitrate', '$this->title', '$this->ext')");
			}

			mysqli_close($connection);
		}

		//Displays all attributes
		public function showAll() {
			echo "UUID - " . $this->uuid;
			echo "DURATION - " . $this->duration;
			echo "NAME " . $this->name;
			echo "DESCRIPTION - " .  $this->description;
			echo "BITRATE = " . $this->bitrate;
			echo "TITLE " . $this->title;
			echo "EXT " . $this->ext;
		}

		//Returns assigned ID of video for player.php
		public function getVID() {
			$connection = new mysqli("localhost", "vortex", "testpassword", "Vortex");

			if ($connection->connect_error) {
					header("Location:http://www.videovortex.stream/php/error.php/31");
    				die("Connection failed: " . $connection->connect_error);
			}

			$result = $connection->query("SELECT ID from VideoData where UUID='$this->uuid';");
			$result_arr = $result->fetch_array(MYSQLI_ASSOC);
			$id = $result_arr['ID'];

			if (is_null($result)) {
				header("Location:http://www.videovortex.stream/php/error.php/31");
				die();
			}

			mysqli_close($connection);
			return $id;

		}
	}
?>

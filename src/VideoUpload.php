<?php
	//Use AWS SDK for S3
	require '/srv/Sites/lib/aws-autoloader.php';
	use Aws\S3\S3Client;
	
	class VideoUpload {

		//Attribute Variables
		private $duration;
		private $bitrate;
		private $name;
		private $description;
		private $location;
		private $uploaded;
		private $created;
		private $file;

		//Shared Variables
		private $ext;
		private $target_file;
		private $bucket;
		private $ffmpeg;
		private $s3Client;
		private $uuid;

		public function __construct($tmp_name, $name) {
			$this->s3Client = S3Client::factory(array(
                        'profile' => 'vigilant',
                        'region'  => 'us-west-2',
                        'version' => 'latest'));

			$this->bucket = 'vortex-bucket';
			$this->tmp_name = $tmp_name;
			$this->name = $name;
			$this->file = basename($name);
			$this->ffmpeg = "/usr/bin/ffmpeg";
		//	$this->localUpload();
			$this->videoAttributes();
		//	$this->preparedSQL();
		}

		//Sanatizes SQL Input to Prevent Injection
		function verifyInput($input) {
			$input = trim($input);
			$input = stripslashes($input);
			$input = htmlspecialchars($input);
			return $input;
		}

		function videoAttributes() {
			$command = $this->ffmpeg . ' -i ' .  $this->tmp_name .  ' -vstats 2>&1 | grep "Duration\|Audio" ';
			$attr_output = shell_exec($command);
			echo "AAAAAAAAAAAAAA " .   $attr_output . "  AAAAAAA";

//			$regex = '.*?((?:2|1)\\d{3}(?:-|\\/)(?:(?:0[1-9])|(?:1[0-2]))(?:-|\\/)(?:(?:0[1-9])|(?:[1-2][0-9])|(?:3[0-1]))(?:T|\\s)(?:(?:[0-1][0-9])|(?:2[0-3])):(?:[0-5][0-9]):(?:[0-5][0-9])).*?((?:(?:[0-1][0-9])|(?:[2][0-3])|(?:[0-9])):(?:[0-5][0-9])(?::[0-5][0-9])?(?:\\s?)?).*?\\d.*?\\d.*?\\d.*?\\d.*?\\d.*?\\d.*?\\d.*?\\d.*?\\d.*?(\\d\\d\\d)';

			$regex = '.*?((?:2|1)\\d{3}(?:-|\\/)(?:(?:0[1-9])|(?:1[0-2]))(?:-|\\/)(?:(?:0[1-9])|(?:[1-2][0-9])|(?:3[0-1]))(?:T|\\s)(?:(?:[0-1][0-9])|(?:2[0-3])):(?:[0-5][0-9]):(?:[0-5][0-9])).*?((?:(?:[0-1][0-9])|(?:[2][0-3])|(?:[0-9])):(?:[0-5][0-9])(?::[0-5][0-9])?(?:\\s?)?).*?\\d.*?\\d.*?\\d.*?\\d.*?\\d.*?\\d.*?\\d.*?\\d.*?\\d.*?(\\d\\d\\d)';			

			if (preg_match_all ("/".$regex."/is", $attr_output, $match)) {
			 echo "AAAAAAAAAAAAAA " .   $attr_output . "  AAAAAAA";

				$this->created = $match[1][0];
  				$this->duration = $match[2][0];
     				$this->bitrate = $match[3][0];
			}
			$this->description = $this->verifyInput($_POST['description']);
			$this->uuid = uniqid();
		}

		function localUpload() {
			if (move_uploaded_file($this->tmp_name,  "/tmp/" . $this->file )) {

				$this->makeThumbnail();
				$this->uploadFile();
			}
			else {
				echo "Error with file upload!";
			}
		}

		function makeThumbnail() {
			$thumb = "/tmp/" . $this->uuid . ".jpg";
			$cmd = $this->ffmpeg . ' -i ' . "/tmp/" . $this->name . ' -deinterlace -an -ss 10 -f mjpeg -t 1 -r 1 -y -s 240x135 ' . $thumb . ' 2>&1';
			$cmd_output = exec($cmd);
		}

		function uploadFile() {

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

		function preparedSQL() {
			$connection = new mysqli("localhost", "vortex", "testpassword", "Vortex");
			if ($connection->connect_error) {
    				die("Connection failed: " . $connection->connect_error);
			}
			else{
				$connection->query("INSERT INTO VideoData (UUID, Duration, Name, Description, Bitrate, Created)
					VALUES ('$this->uuid', '$this->duration', '$this->name', '$this->description', '$this->bitrate', '$this->created')");
			}

			mysqli_close($connection);
		}

		function showAll() {
			echo "UUID - " . $this->uuid;
			echo "DURATION - " . $this->duration;
			echo "NAME " . $this->name;
			echo "DESCRIPTION - " .  $this->description;
			echo "BITRATE = " . $this->bitrate;
			//echo $this->uploaded;
			echo "CREATED   =  " . $this->created;
			//echo $this->file;
		}
	}
?>

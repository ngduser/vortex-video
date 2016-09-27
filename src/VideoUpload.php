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
		private $uuid;
		private $title;

		//Shared Variables
		private $ext;
		private $target_file;
		private $bucket;
		private $ffmpeg;
		private $s3Client;

		public function __construct($tmp_name, $name) {
			$this->s3Client = S3Client::factory(array(
                        'profile' => 'vigilant',
                        'region'  => 'us-west-2',
                        'version' => 'latest'));

			$this->bucket = 'vortex-bucket';
			$this->tmp_name = $tmp_name;

			echo "TTTT- " . $tmp_name . "        ";
			$this->name = $name;
			$this->file = basename($name);
			$this->ffmpeg = "/usr/bin/ffmpeg";
			$this->videoAttributes();
			echo "<pre>"; 
echo "POST:"; 
print_r($_POST); 
echo "FILES:"; 
print_r($_FILES); 
echo "</pre>";  
		}

		//Sanatizes SQL Input to Prevent Injection
		function verifyInput($input) {
			$input = trim($input);
			$input = stripslashes($input);
			$input = htmlspecialchars($input);
			return $input;
		}

		function videoAttributes() {

			echo $this->ffmpeg . ' -i ' .  $this->tmp_name .  ' -vstats 2>&1 | grep "Duration\|Audio"';
			$command = exec($this->ffmpeg . ' -i ' .  $this->tmp_name .  ' -vstats 2>&1 | grep "Duration\|Audio" ', $attr_output, $return);
			echo $command;
			if ($return){ 
				echo "error with Attributes";
			}

			$regex='.*?((?:(?:[0-1][0-9])|(?:[2][0-3])|(?:[0-9])):(?:[0-5][0-9])(?::[0-5][0-9])?(?:\\s?(?:am|AM|pm|PM))?).*?\\d+.*?\\d+.*?\\d+.*?(\\d+)';


			if (preg_match_all ("/".$regex."/is", $attr_output, $match)) {
 				$this->duration = $match[1][0];
     				$this->bitrate = $match[2][0];
			}
			$this->description = $this->verifyInput($_POST['description']);
			$this->title = $this->verifyInput($_POST['title']);
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
			$cmd = $this->ffmpeg . ' -i ' . "/tmp/" . $this->name . ' -ss 1 -y -f mjpeg -s 240x135 -vframes 1 ' . $thumb;
			$cmd_output = exec($cmd);
   //    			$path = "/tmp/ . $this->name"; 
//		        $this->ext = pathinfo($path, PATHINFO_EXTENSION);
		}

		function uploadFile() {
	
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

		function preparedSQL() {
			$connection = new mysqli("localhost", "vortex", "testpassword", "Vortex");
			if ($connection->connect_error) {
    				die("Connection failed: " . $connection->connect_error);
			}
			else{
				$connection->query("INSERT INTO VideoData ( UUID, Duration, Name, Description, Bitrate, Title)
					VALUES ( '$this->uuid', '$this->duration', '$this->name', '$this->description', '$this->bitrate', '$this->title')");
			}

			mysqli_close($connection);
		}

		function showAll() {
			echo "UUID - " . $this->uuid;
			echo "DURATION - " . $this->duration;
			echo "NAME " . $this->name;
			echo "DESCRIPTION - " .  $this->description;
			echo "BITRATE = " . $this->bitrate;
			echo "TITLE " . $this->title;
//			echo "EXT " . $this->ext;
		}
	}
?>

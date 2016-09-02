<?php
	//Use AWS SDK for S3
	require '/srv/Sites/lib/aws-autoloader.php';
	use Aws\S3\S3Client;
	
	class VideoUpload {

		//Static Variables
		private $length;
		private $bucket = 'vigilant-bucket';
		private $ffmpeg;
		
		public $s3Client;
		public $url;
	        public $attributes;

		public function __construct($tmp_name, $name) {
			$this->s3Client = S3Client::factory(array(
                        'profile' => 'vigilant',
                        'region'  => 'us-west-2',
                        'version' => 'latest'));

			$this->tmp_name = $tmp_name;
			$this->name = $name;
			$target_file = "uploads/" . basename($name);
			$ext = pathinfo($target_file,PATHINFO_EXTENSION);
			$id = null;
			$video_name = basename($name);
			$this->ffmpeg = "/usr/bin/ffmpeg";


		}
		//Sanatizes SQL Input to Prevent Injection
		function verifyInput($input) {
			$input = trim($input);
			$input = stripslashes($input);
			$input = htmlspecialchars($input);
			return $input;
		} 
  
		function videoAttributes() {
                        $command= $this->ffmpeg . ' -i ' .  $this->tmp_name .  ' -vstats 2>&1 | grep "Duration\|Audio\|creation" ';
                        $attributes = shell_exec($command);
                        $this->attributes = $attributes;
                        $regex_duration = '(Duration:\\s+)';
                        $regex_length = '((?:(?:[0-1][0-9])|(?:[2][0-3])|(?:[0-9])):(?:[0-5][0-9])(?::[0-5][0-9])?(?:\\s?)?\\.\\d+)';

                        if (preg_match_all ("/".$regex_duration.$regex_length."/is", $attributes, $match)) {
                                $this->length = $match[2][0];
                        }
                }

		function localUpload() {
			if (move_uploaded_file($tmp_name, $target_file)) {
        		echo "The file ". basename($name). " has been uploaded.";
			} 
			
			else {
				echo "Error with file upload!";
			}

		}

		function makeThumbnail() {
			$cmd = "$ffmpeg -i $target_file -deinterlace -an -ss 10 -f mjpeg -t 1 -r 1 -y -s 240x135 $thmb 2>&1";
			$cmd_output = exec($cmd);
		}

		function uploadFile($key, $path) {
			$keyname = $id . "." . $ext;

			//Transfer Local Upload to Bucket
			$filepath = "/srv/Sites/Vigilant/www/php/uploads/" . $id;
			$operation = $s3Client->putObject(array(
    				'Bucket'       => $bucket,
   				'Key'          => $keyname,
    				'SourceFile'   => $filepath,
    				'ContentType'  => 'text/plain',
    				'ACL'          => 'public-read',
    				'StorageClass' => 'REDUCED_REDUNDANCY',));

			$url = $operation['ObjectURL'];
		}
			
		function finishClean() {
			unlink($target_file);
		}
	}
?>		

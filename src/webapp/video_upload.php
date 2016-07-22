<?php

	class VideoUpload {
		$ffmpeg = '/usr/bin/ffmpeg';
		$ext = pathinfo($target_file,PATHINFO_EXTENSION);
		$video_name = basename($_FILES["uploaded_video"]["name"]);
		$id = uniqid();
		$target_file = "uploads/" . basename($_FILES["uploaded_video"]["name"]);
		$length;
		$bucket = 'vigilant-bucket';
J
		$s3Client = S3Client::factory(array(
   			'profile' => 'vigilant',
   			'region'  => 'us-west-2',
   			'version' => 'latest'));
		

		//Sanatizes SQL Input to Prevent Injection
		function verifyInput($input) {
			$input = trim($input);
			$input = stripslashes($input);
			$input = htmlspecialchars($input);
			return $input;
		} 

		function videoAttributes() {
			$command = $ffmpeg . ' -i ' . $_FILES["uploaded_video"]["tmp_name"] .  ' -vstats 2>&1 | grep Duration';
			$attributes = shell_exec($command);

			$regex_duration = '(Duration:\\s+)';
			$regex_length = '((?:(?:[0-1][0-9])|(?:[2][0-3])|(?:[0-9])):(?:[0-5][0-9])(?::[0-5][0-9])?(?:\\s?)?\\.\\d+)';

			if (preg_match_all ("/".$regex_duration.$regex_length."/is", $attributes, $match)) {
      			$this->length = $match[2][0];
      		}
		}

		function localUpload() {
			if (move_uploaded_file($_FILES["uploaded_video"]["tmp_name"], $target_file)) {
        		echo "The file ". basename($_FILES["uploaded_video"]["name"]). " has been uploaded.";
			} else {
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
			}

			$url = $operation['ObjectURL'];
			
			//Fix
			unlink($target_file);
?>
<!DOCTYPE html>
<html>
<body>

<?php

//Set Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

//Use AWS SDK for S3
require '/srv/Sites/lib/aws-autoloader.php';
use Aws\S3\S3Client;

//Validate Upload as Video and Determine Video Length with Regex
$ffmpeg = '/usr/bin/ffmpeg';
$target_file = "uploads/" . basename($_FILES["uploaded_video"]["name"]);

$command = $ffmpeg . ' -i ' . $_FILES["uploaded_video"]["tmp_name"] .  ' -vstats 2>&1 | grep Duration';
$attributes = shell_exec($command);

$regex_duration = '(Duration:\\s+)';
$regex_length = '((?:(?:[0-1][0-9])|(?:[2][0-3])|(?:[0-9])):(?:[0-5][0-9])(?::[0-5][0-9])?(?:\\s?)?\\.\\d+)';

if (preg_match_all ("/".$regex_duration.$regex_length."/is", $attributes, $match)){
      $length = $match[2][0];

}

//Determine Extention for Filetype
$ext = pathinfo($target_file,PATHINFO_EXTENSION);

//Set S3 Profile
$s3Client = S3Client::factory(array(
   'profile' => 'vigilant',
   'region'  => 'us-west-2',
   'version' => 'latest',
     ));
$video_name = basename($_FILES["uploaded_video"]["name"]);

$id = uniqid();

//Upload File Locally
$target_file = "uploads/" . $id;

if (move_uploaded_file($_FILES["uploaded_video"]["tmp_name"], $target_file)) {
        echo "The file ". basename($_FILES["uploaded_video"]["name"]). " has been uploaded.";
} else {
	echo "Error with file upload!";
}

$thmb = "/srv/Sites/Vigilant/www/php/uploads/" . $id . ".jpg"; 
$cmd = "$ffmpeg -i $target_file -deinterlace -an -ss 10 -f mjpeg -t 1 -r 1 -y -s 240x135 $thmb 2>&1";
$cmd_output = exec($cmd);

//Set S3 Bucket
$bucket = 'vigilant-bucket';
$keyname = $id . "." . $ext;

//Transfer Local Upload to Bucket
$filepath = "/srv/Sites/Vigilant/www/php/uploads/" . $id;
$operation = $s3Client->putObject(array(
    'Bucket'       => $bucket,
    'Key'          => $keyname,
    'SourceFile'   => $filepath,
    'ContentType'  => 'text/plain',
    'ACL'          => 'public-read',
    'StorageClass' => 'REDUCED_REDUNDANCY',
    ));

$url = $operation['ObjectURL'];

$thmbkey = $id . ".jpg";

$thmb_operation = $s3Client->putObject(array(
    'Bucket'       => $bucket,
    'Key'          => $thmbkey,
    'SourceFile'   => $thmb,
    'ContentType'  => 'text/plain',
    'ACL'          => 'public-read',
    'StorageClass' => 'REDUCED_REDUNDANCY',
    ));

$thmb_url = $thmb_operation['ObjectURL'];

unlink($target_file);
unlink($thmb);

//Connect to vigilant Database and Update Video Table
$conn = new mysqli();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$name = verify_input($video_name);
	$u_id = verify_input($_POST['u_id']);
	$description = verify_input($_POST['description']);
}

//Sanatizes SQL Input to Prevent Injection
function verify_input($input) {
	$input = trim($input);
	$input = stripslashes($input);
	$input = htmlspecialchars($input);
	return $input;
}

//SQl Command to Update Video Columns
$conn->query("INSERT INTO Video (file_type, tn_id, vid_filepath, length_sec, name, u_id, description)
	VALUES ('$ext', '$thmb_url', '$url', '$length', '$name', '$u_id', '$description')");

mysqli_close($conn);

?>

</body>
</html>

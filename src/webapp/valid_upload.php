<!DOCTYPE html>
<html>
<body>

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$ffmpeg = '/usr/bin/ffmpeg';
$target_file = "uploads/" . basename($_FILES["uploaded_video"]["name"]);


$command = $ffmpeg . ' -i ' . $_FILES["uploaded_video"]["tmp_name"] .  ' -vstats 2>&1 | grep Duration';
$attributes = shell_exec($command);  
echo  $attributes;

$regex_duration = '(Duration:\\s+)';	
$regex_length = '((?:(?:[0-1][0-9])|(?:[2][0-3])|(?:[0-9])):(?:[0-5][0-9])(?::[0-5][0-9])?(?:\\s?)?\\.\\d+)';

if (preg_match_all ("/".$regex_duration.$regex_length."/is", $attributes, $match))
{
      $length = $match[2][0];
      echo $length;
}


$ext = pathinfo($target_file,PATHINFO_EXTENSION);


if (move_uploaded_file($_FILES["uploaded_video"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["uploaded_video"]["name"]). " has been uploaded.";
} else {
	echo "Error with file upload!";
}

$conn = new mysqli(REMOVED);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$name = verify_input($_POST['name']);
	$u_id = verify_input($_POST['u_id']);
	$description = verify_input($_POST['description']);
}

function verify_input($input) {
	$input = trim($input);
	$input = stripslashes($input);
	$input = htmlspecialchars($input);
	return $input;
}



//$conn->query("INSERT INTO Video (file_type, length_sec, name, u_id, views, vid_filepath, tn_id, description)
//	VALUES ('$file_type', '$length_sec', '$name',
//	 '$u_id', '$views', '$vid_filepath', '$tn_id','$description')");

$conn->query("INSERT INTO Video (name, u_id, description)
	VALUES ('$name', '$u_id', '$description')");

mysqli_close($conn);

?>

<h2>Database Updated!</h2>
<a href="/php/show_video.php">View Records</a>

</body>
</html>

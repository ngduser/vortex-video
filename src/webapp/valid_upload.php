<!DOCTYPE html>
<html>
<body>

<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$target_file = "uploads/" . basename($_FILES["uploaded_video"]["name"]);

 if (move_uploaded_file($_FILES["uploaded_video"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["uploaded_video"]["name"]). " has been uploaded.";
} else {
	echo "Error with file upload!";
}

$conn = new mysqli("localhost", "495", "aQXGsyYCwy3n4FeM", "vigilant");

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

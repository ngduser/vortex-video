<?php

	//Connect to vigilant Database and Update Video Table
	$conn = new mysqli("localhost", "495", "aQXGsyYCwy3n4FeM", "vigilant");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$name = verify_input($video_name);
	$u_id = verify_input($_POST['u_id']);
	$description = verify_input($_POST['description']);
}
	
	//Sanatizes SQL Input to Prevent Injection
function verifyInput($input) {
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
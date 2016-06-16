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
        echo "Sorry, there was an error uploading your file.";
    }

$connection = new mysqli(REMOVED);

	$v_id= $_POST['v_id'];
	$file_type= $_POST['file_type'];
	$length_sec= $_POST['length_sec'];
	$name= $_POST['name'];
	$u_id= $_POST['u_id'];
	$views= $_POST['views'];
	$vid_filepath= $_POST['vid_filepath'];
	$tn_id= $_POST['tn_id'];
	$description= $_POST['description'];

$connection->query("INSERT INTO Video
	VALUES ('$v_id', '$file_type', '$length_sec', '$name',
'$u_id', '$views', '$vid_filepath', '$tn_id','$description')");

mysqli_close($connection);

?>

<h2>Database Updated!</h2>
<a href="/webapp/show_video.php">View Records</a>

</body>
</html>

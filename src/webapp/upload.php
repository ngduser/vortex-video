<!DOCTYPE html>
<html>
<body>

<?php

$connection = mysqli_connect(TBD);


	$v_id= $_POST['v_id'];
	$file_type= $_POST['file_type'];
	$length_sec= $_POST['length_sec'];
	$name= $_POST['name'];
	$u_id= $_POST['u_id'];
	$views= $_POST['views'];
	$vid_filepath= $_POST['vid_filepath'];
	$tn_id= $_POST['tn_id'];
	$description= $_POST['description'];

$sql = "INSERT INTO TESTVIDEO
	VALUES ('$v_id', '$file_type', '$length_sec', '$name',
	 '$u_id', '$views', '$vid_filepath', '$tn_id','$description')";

$query = mysqli_exec($connection, $sql)
		 or die (mysqli_errormsg());

mysqli_close($connection);

?>

<h2>Database Updated!</h2>
<a href="/webapp/show_video.php">View Records</a>

</body>
</html>

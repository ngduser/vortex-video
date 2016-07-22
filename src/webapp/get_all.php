<?php

header('Access-Control-Allow-Origin:*');
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = new mysqli();



if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$result = $conn->query("Select * from Video");
$vid_array = array();

while ($row = mysqli_fetch_array($result)) {
    $vid_array[] = $row;
}

echo json_encode($vid_array);
mysqli_close($conn);

?>

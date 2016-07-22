<?php
header('Access-Control-Allow-Origin:*');

error_reporting(E_ALL);
ini_set('display_errors', 1);


header('Content-Type: application/json');
$video_id = $_SERVER['PATH_INFO'];
$video_id = trim ($video_id , '/');

$video_id;
$conn = new mysqli();
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$result = $conn->query("Select * from Video where v_id=$video_id");

while ($row = mysqli_fetch_array($result)) {
    echo json_encode($row);
} 


mysqli_close($conn);

?>




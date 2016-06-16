<html>
<body>

<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


$video_id= $_POST['v_id'];

       
$connection = new mysqli(REMOVED);



if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
} 
 

$result = $connection->query("Select * from Video where v_id=$video_id");

while ($row = mysqli_fetch_array($result)) {
    echo json_encode($row);
} 

mysqli_close($connection);

?>


</body>
</html>




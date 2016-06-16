<!DOCTYPE html>
<html>
<body>

<h1>Video Data</h1>

<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
$connection = new mysqli(REMOVED);


if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
} 
 

$result = $connection->query("Select * from Video");



echo "<B>Video Table</B>";
echo "<P/>";
echo "<TABLE BORDER=1>"; 
echo "<TR>
        <TH>v_id</TH> 
        <TH>file_type</TH>
        <TH>length_sec</TH>
        <TH>name</TH>
        <TH>u_id</TH>
        <TH>views</TH>
        <TH>vid_filepath</TH>
        <TH>tn_id</TH>
        <TH>description</TH> <TR>"; 


while ($row = mysqli_fetch_array($result)) {
    echo "<TR>";
    foreach ($row as $entry) {
         echo "<TD>".$entry."</TD>";
    }
    
    echo "<TR>";
} 


$result->close();
mysqli_close($connection); 
?>

<form enctype="multipart/form-data" form action="get_json.php" method="post">
v_id: <input class="input" name="v_id"><br>

<table border= "1">

<input type="submit" value="Get Json" name="submit">


</form>

</body>
</html>

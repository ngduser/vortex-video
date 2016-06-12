<!DOCTYPE html>
<html>
<body>

<h1>Video Data</h1>

<?php

$connection = mysqli('no','nousername','nopassword');

$sql = "SELECT *;  
          FROM Video;"

$query = mysqli_exec($connection, $sql)  
            or die (mysqli_errormsg());


echo "<B>Video Table</B>";
echo "<P />";
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


while($row = mysqli_fetch_array($query)) { 
    echo "<TR>";
    echo "<TD>".$row."</TD>";
 
    echo "</TR>"; 
} 

echo "</TABLE>"; 


mysqli_close($connection); 
?>

</body>
</html>

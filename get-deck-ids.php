<!DOCTYPE html>
<html>
<head></head>
<body>
<?php
$conn = mysqli_connect('localhost', 'root', '', 'card_database');
if($conn->connect_errno){
echo("failed to connect!");
}
else{
$resultset = $conn->query("SELECT `deck_id` FROM `deck_database`")->fetch_all();
for($i = count($resultset) - 1; $i >= 0; --$i){
echo $resultset[$i][0];
if($i != 0) echo "<br>";
}
}
?>
</body>
</html>
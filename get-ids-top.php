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
$resultset = $conn->query("SELECT `card_id` FROM `custom_cards` ORDER BY `points` DESC, `card_id` ASC")->fetch_all();
$reverse_set = array_reverse($resultset);
for($i = count($reverse_set) - 1; $i >= 0; --$i){
echo $reverse_set[$i][0];
if($i != 0) echo "<br>";
}
}
$conn->close();
?>
</body>
</html>
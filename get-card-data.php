<html>
<head></head>
<body>
<?php
$conn = mysqli_connect('localhost', 'root', '', 'card_database');
if($conn->connect_errno){
echo("failed to connect!");
}
else{
$result = $conn->query("SELECT `description` FROM `custom_cards` WHERE `card_id` = ".$_GET['id']);
$string = $result->fetch_all()[0][0];
echo $string;
}
?>
</body>
</html>

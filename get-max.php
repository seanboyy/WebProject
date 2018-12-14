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
	$database = $_GET['type'] === "card" ? "`custom_cards`" : ($_GET['type'] === "deck" ? "`deck_database`" : "");
	$_id = $_GET['type'] === "card" ? "`card_id`" : ($_GET['type'] === "deck" ? "`deck_id`" : "");
	$max = $conn->query("SELECT max(".$_id.") FROM ".$database)->fetch_all()[0][0];
	echo $max;
}
$conn->close();
?>
</body>
</html>
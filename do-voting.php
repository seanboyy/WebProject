<!DOCTYPE html>
<html>
<head></head>
<body>
<?php
	$conn = mysqli_connect('localhost', 'root', '', 'card_database');
	$type = $_GET['type'] === "card" ? "`custom_cards`" : ( $_GET['type'] === "deck" ? "`deck_database" :  "");
	$id = $_GET['type'] === "card" ? "`card_id`" : ( $_GET['type'] === "deck" ? "`deck_id`" : "");
	if($conn->connect_errno) {
		echo("failed to connect!");
	}
	else {
		if(isset($_GET['isUpvoting'])) {
			if(isset($_GET['hasUpvoted'])) {
				$conn->query("UPDATE ".$type." SET `points` = `points` - 1 WHERE ".$id." = ".$_GET['id']);
			}
			else if(isset($_GET['hasDownvoted'])) {
				$conn->query("UPDATE ".$type." SET `points` = `points` + 2 WHERE ".$id." = ".$_GET['id']);
			}
			else{
				$conn->query("UPDATE ".$type." SET `points` = `points` + 1 WHERE ".$id." = ".$_GET['id']);
			}
		}
		else if(isset($_GET['isDownvoting'])) {
			if(isset($_GET['hasUpvoted'])) {
				$conn->query("UPDATE ".$type." SET `points` = `points` - 2 WHERE ".$id." = ".$_GET['id']);
			}
			else if(isset($_GET['hasDownvoted'])) {
				$conn->query("UPDATE ".$type." SET `points` = `points` + 1 WHERE ".$id." = ".$_GET['id']);
			}
			else{
				$conn->query("UPDATE ".$type." SET `points` = `points` - 1 WHERE ".$id." = ".$_GET['id']);
			}
		}
		echo $conn->query("SELECT `points` FROM ".$type." WHERE ".$id." = ".$_GET['id'])->fetch_all()[0][0];
	}
?>
</body>
</html>
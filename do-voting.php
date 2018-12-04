<!DOCTYPE html>
<html>
<head></head>
<body>
<?php
	if($_GET['type'] === "card") {
		$conn = mysqli_connect('localhost', 'root', '', 'card_database');
		if($conn->connect_errno) {
			echo("failed to connect!");
		}
		else {
			if($_GET['isUpvoting'] == "true"){
				if($_GET['hasUpvoted'] == "true"){
					$conn->query("UPDATE `custom_cards` SET `points` = `points` - 1 WHERE `card_id` = ".$_GET['card_id']);
				}
				else if($_GET['hasDownvoted'] == "true"){
					$conn->query("UPDATE `custom_cards` SET `points` = `points` + 2 WHERE `card_id` = ".$_GET['card_id']);
				}
				else{
					$conn->query("UPDATE `custom_cards` SET `points` = `points` + 1 WHERE `card_id` = ".$_GET['card_id']);
				}
			}
			else if($_GET['isDownvoting'] == "true"){
				if($_GET['hasUpvoted'] == "true"){
					$conn->query("UPDATE `custom_cards` SET `points` = `points` - 2 WHERE `card_id` = ".$_GET['card_id']);
				}
				else if($_GET['hasDownvoted'] == "true"){
					$conn->query("UPDATE `custom_cards` SET `points` = `points` + 1 WHERE `card_id` = ".$_GET['card_id']);
				}
				else{
					$conn->query("UPDATE `custom_cards` SET `points` = `points` - 1 WHERE `card_id` = ".$_GET['card_id']);
				}
			}
			echo $conn->query("SELECT `points` FROM `custom_cards` WHERE `card_id` = ".$_GET['card_id'])->fetch_all()[0][0];
		}
	}
?>
</body>
</html>
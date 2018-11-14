<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Magic Maker - Card Uploading</title>
	</head>
	<body>
		<?php
			$servername = "127.0.0.1";
			$username = "root";
			$password = "";
			$dbname = "card_database";

			// These hold the values we will output in the JSON
			$statusMessage = "";

			// Check that we received a POST request
			if( $_SERVER['REQUEST_METHOD'] === 'POST' )
			{
				if(!isset($_POST["card-name"]) || !is_string($_POST["card-name"])) {}
				if(!isset($_POST["mana-cost"]) || !is_string($_POST["mana-cost"])) {}
				if(!isset($_POST["type-line"]) || !is_string($_POST["type-line"])) {}
				if(!isset($_POST["rarity"]) || !is_int($_POST["rarity"])) {}
				if(!isset($_POST["rules-text"]) || !is_string($_POST["rules-text"])) {}
				if(!isset($_POST["power"]) || !is_int($_POST["power"])) {}
				if(!isset($_POST["toughness"]) || !is_int($_POST["toughness"])) {}
				if(!isset($_POST["description"]) || !is_string($_POST["description"])) {}
				
				// We have a customer number
				// Search the DB for account matches
				// TODO: set $statusMessage and $accounts
				//   from the DB
				// Use a prepared statement, since the customer_no
				//   is from the user
				// Create connection
				$conn = new mysqli($servername, $username, $password, $dbname);
				// Check connection
				if ($conn->connect_errno) 
				{
					$statusMessage = "Could not connect to database";
				}
				else
				{
					$cardid = 0;
					$conn->real_query("SELECT COUNT(*) FROM `custom_cards`");
					$count_res = $conn->use_result();
					$count = $count_res->fetch_all(MYSQLI_NUM);
					if($count[0] > 0){
						$cardid = $conn->real_query("SELECT max(card_id) FROM `custom_cards`");
						$cardid_res = $conn->use_result();
						$cardid = $cardid_res->fetch_all(MYSQLI_NUM)[0];
					}
					$cardid++;
					$userid = -1;
					$picloc = "";
					$stmt = $conn->prepare("INSERT INTO `custom_cards` VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
					$stmt->bind_param("isssisiiiss", $cardid, $_POST["card-name"], $_POST["mana-cost"], $_POST["type-line"], $_POST["rarity"], $_POST["rules-text"], $_POST["power"], $_POST["toughness"], $userid, $_POST["description"], $picloc);
					$stmt->execute();
				}
			}
			else
			{
				$statusMessage = "No PUSH request received.";
			}
			
		?>
	</body>
</html>
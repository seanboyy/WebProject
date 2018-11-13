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
			$dbname = "web_project";

			// These hold the values we will output in the JSON
			$statusMessage = "";

			// Check that we received a POST request
			if( $_SERVER['REQUEST_METHOD'] === 'POST' )
			{
				if(!isset($_POST["card_name"]) || !is_string($_POST["card_name"])) {}
				if(!isset($_POST["mana_cost"]) || !is_string($_POST["mana_cost"])) {}
				if(!isset($_POST["type-line"]) || !is_string($_POST["type-line"])) {}
				if(!isset($_POST["rarity"]) || !is_int($_POST["rarity"])) {}
				if(!isset($_POST["rules"]) || !is_string($_POST["rules"])) {}
				if(!isset($_POST["power"]) || !is_int($_POST["power"])) {}
				if(!isset($_POST["toughness"]) || !is_int($_POST["toughness"])) {}
				if(!isset($_POST["description"]) || !is_string($_POST["string"])) {}
				
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
					$stmt = $conn->prepare("INSERT INTO custom_cards (card_name, mana_cost, type, rarity, rules, power, toughness, creator_id, description)VALUES ?, ?, ?, ?, ?, ?, ?, ?, ?, ?");
					$stmt->bind_param("sssisiis", $_POST["card_name"], $_POST["mana_cost"], $_POST["type-line"], $_POST["rarity"], $_POST["rules"], $_POST["power"], $_POST["toughness"], -1, $_PUSH["description"]);
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
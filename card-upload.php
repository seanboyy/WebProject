<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Magic Maker - Card Uploading</title>
	</head>
	<body>
		<?php
			// Since we are outputting JSON, we do not need the HTML boilerplate


			// Example output:
			// {"status":"Success", "accounts":[
			//  {"account_no":"5609","balance":"500.50"},
			//  {"account_no":"5610","balance":"200.50"}
			// ]}

			// Example output:
			// {"status":"Invalid customer number: foo", "accounts":[]}
			// DB connection parameters
			$servername = "127.0.0.1";
			$username = "root";
			$password = "";
			$dbname = "web_project";

			// These hold the values we will output in the JSON
			$statusMessage = "";
			$accounts = array();

			// Check that we received a POST request
			if( $_SERVER['REQUEST_METHOD'] === 'POST' )
			{
				if(!isset($_POST["card_name"]) && is_string($_POST["card_name"])) {}
				if(!isset($_POST["mana_cost"]) && is_string($_POST["mana_cost"])) {}
				if(!isset($_POST["type-line"])) {}
				if(!isset($_POST["rarity"])) {}
				if(!isset($_POST["rules"])) {}
				if(!isset($_POST["power"])) {}
				if(!isset($_POST["toughness"])) {}
				if(!isset($_POST["description"])) {}
				
				$customer_no = intval($_GET["customer_no"]);
				if($customer_no !== 0)
				{
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
						$stmt->bind_param("i", $customer_no);
						$stmt->execute();
						// Array to hold account information
						$accounts = array();
						$res = $stmt->get_result();
					}
				}
				else
				{
					$statusMessage = "Invalid customer number: " . $_GET["customer_no"];
				}
			}
			else
			{
				$statusMessage = "No customer number provided.";
			}
			}
			else
			{
				$statusMessage = "No GET request received.";
			}

			// TODO: Format and echo the result in JSON
			// HINT: use the built-in PHP functions to help create the JSON format
			$jsonArray = array("status" => $statusMessage, "accounts" => $accounts);
			echo(json_encode($jsonArray));
		?>
	</body>
</html>
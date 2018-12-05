<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Magic Maker - Deck Uploading</title>
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
				if(!isset($_POST["deck-name"]) || !is_string($_POST["deck-name"])) {}
				if(!isset($_POST["deck-list"]) || !is_string($_POST["deck-list"])) {}
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
					$deckid = 0;
					$conn->real_query("SELECT COUNT(*) FROM `deck_database`");
					$count_res = $conn->use_result();
					$count = $count_res->fetch_all(MYSQLI_NUM)[0];
					if($count > 0){
						$conn->real_query("SELECT max(deck_id) FROM `deck_database`");
						$deckid_res = $conn->use_result();
						$deckid = $deckid_res->fetch_all(MYSQLI_NUM)[0];
					}
					$deckid[0]++;
					$userid = -1;
					$points = 0;
					$stmt = $conn->prepare("INSERT INTO `deck_database` VALUES (?, ?, ?, ?, ?, ?)");
					$stmt->bind_param("issisi", $deckid[0], $_POST["deck-list"], $_POST["description"], $userid, $_POST["deck-name"], $points);
					$stmt->execute();
				}
			}
			else
			{
				$statusMessage = "No POST request received.";
			}
			
		?>
		<p><a href="./">Back to main page</a></p>
	</body>
</html>
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

				$fileInfo = $_FILES["card-img"];
				
				$picloc = "";
				if (!empty($fileInfo["name"]))
				{
					$validMime = ["image/jpeg", "image/png"];
					$maxFileSize = 2000000;
					
					if($fileInfo["error"] != UPLOAD_ERR_OK)
					{
						// an error occurred
						echo("An error occured uploading the file");
					} 
					else if (!in_array($fileInfo["type"], $validMime))
					{
						echo("File type not supported");
					}
					else if ($fileInfo["size"] > $maxFileSize)
					{
						echo("File is too large, max size is 2MB");
					}
					else
					{
						// Move the file from temporary location
						if ($fileInfo["type"] == "image/jpeg")
						{
							$extension = ".jpg";
						}
						else if ($fileInfo["type"] == "image/png")
						{
							$extension = ".png";
						}
						$dest = "./card_images/" . $_POST["card-name"] . $extension;
						if (move_uploaded_file($fileInfo["tmp_name"], $dest))
						{
							$picloc = $dest;
							echo("File uploaded successfully");
						}
						else 
						{
							echo("There was a problem uploading the file");
						}
					}
				}
				
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
					$count = $count_res->fetch_all(MYSQLI_NUM)[0];
					if($count > 0){
						$conn->real_query("SELECT max(card_id) FROM `custom_cards`");
						$cardid_res = $conn->use_result();
						$cardid = $cardid_res->fetch_all(MYSQLI_NUM)[0];
					}
					$cardid[0]++;
					$userid = -1;
					$stmt = $conn->prepare("INSERT INTO `custom_cards` VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
					$stmt->bind_param("isssisiiiss", $cardid[0], $_POST["card-name"], $_POST["mana-cost"], $_POST["type-line"], $_POST["rarity"], $_POST["rules-text"], $_POST["power"], $_POST["toughness"], $userid, $_POST["description"], $picloc);
					$stmt->execute();
				}
			}
			else
			{
				$statusMessage = "No POST request received.";
			}
			
		?>
	</body>
</html>
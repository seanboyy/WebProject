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
			{	$input = $_POST;
				if(!isset($input["card-name"]) || !is_string($input["card-name"])) {}
				if(!isset($input["mana-cost"]) || !is_string($input["mana-cost"])) {}
				if(!isset($input["type-line"]) || !is_string($input["type-line"])) {}
				if(!isset($input["rarity"]) || !is_int($input["rarity"])) {}
				if(!isset($input["rules-text"]) || !is_string($input["rules-text"])) {}
				if(!isset($input["power"]) || !is_int($input["power"])) { $input["power"] = -58; }
				if(!isset($input["toughness"]) || !is_int($input["toughness"])) { $input["toughness"] = -58; }
				if(!isset($input["description"]) || !is_string($input["description"])) {}

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
						$dest = "./card_images/" . $input["card-name"] . $extension;
						if (move_uploaded_file($fileInfo["tmp_name"], $dest))
						{
							$picloc = $dest;
							echo("File uploaded successfully <br>");
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
					$userid = $_SESSION["userid"];
					$points = 0;
					if ($stmt = $conn->prepare("INSERT INTO `custom_cards` VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"))					
					{
						$stmt->bind_param("isssisiiissi", $cardid[0], $input["card-name"], $input["mana-cost"], $input["type-line"], $input["rarity"], $input["rules-text"], $input["power"], $input["toughness"], $userid, $input["description"], $picloc, $points);
						$stmt->execute();
				}
					else
					{
						$error = $conn->errno . ' ' . $conn->error;
						echo $error; 
					}
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
<?php
	session_start();
	if(!isset($_SESSION["userid"]))
	{
		include "./redirect.php";
		forceRedirect("./login.html");
	}
?>
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
				if(!isset($input["power"])) { $input["power"] = -101; }
				if(!isset($input["toughness"])) { $input["toughness"] = -101; }

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
					if (!isset($_POST["card-id"]))	// Adding a card for the first time
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
							
							echo("<p><a href=\"./card-view.php?id=" . $cardid[0] . "\">Back to card view</a></p>");
							forceRedirect("./card-view.php?id=" . $cardid[0]);
						}
						else
						{
							$error = $conn->errno . ' ' . $conn->error;
							echo $error; 
						}
					}
					else
					{
						if (isset($picLoc))
						{
							if ($stmt = $conn->prepare("UPDATE `custom_cards` SET `card_name`=?, `mana_cost`=?, `type`=?, `rarity`=?, `rules`=?, `power`=?, `toughness`=?, `description`=?, `card_image`=? WHERE card_id = ?"))					
							{
								$stmt->bind_param("sssisiissi", $input["card-name"], $input["mana-cost"], $input["type-line"], $input["rarity"], $input["rules-text"], $input["power"], $input["toughness"], $input["description"], $picLoc, $input["card-id"]);
								$stmt->execute();
							}
							else
							{
								$error = $conn->errno . ' ' . $conn->error;
								echo $error; 
							}
						}
						else
						{
							if ($stmt = $conn->prepare("UPDATE `custom_cards` SET `card_name`=?, `mana_cost`=?, `type`=?, `rarity`=?, `rules`=?, `power`=?, `toughness`=?, `description`=? WHERE card_id = ?"))					
							{
								$stmt->bind_param("sssisiisi", $input["card-name"], $input["mana-cost"], $input["type-line"], $input["rarity"], $input["rules-text"], $input["power"], $input["toughness"], $input["description"], $input["card-id"]);
								$stmt->execute();
								
							}
							else
							{
								$error = $conn->errno . ' ' . $conn->error;
								echo $error; 
							}
						}
						
						echo("<p><a href=\"./card-view.php?id=" . $input["card-id"] . "\">Back to card view</a></p>");
						forceRedirect("./card-view.php?id=" . $input["card-id"]);

					}
				}
			}
			else
			{
				$statusMessage = "No POST request received.";
			}
			
			// Found at https://css-tricks.com/snippets/php/redirect/
			function forceRedirect($url = '/'){
				if(!headers_sent()) {
					header('HTTP/1.1 301 Moved Permanently');
					header('Location:'.$url);  
					header('Connection: close');
					exit;
				}
				else {
					echo 'location.replace('.$url.');';
				}
				exit;
			}
		?>
	</body>
</html>
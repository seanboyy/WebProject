<!-- do database stuff; redirect back to sending page -->
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Magic Maker - Remove Comment</title>
	</head>
	<body>
		<?php
			include "./redirect.php";
			
			$servername = "127.0.0.1";
			$username = "root";
			$password = "";
			$dbname = "card_database";

			// These hold the values we will output in the JSON
			$statusMessage = "";

			// Check that we received a POST request
			if( $_SERVER['REQUEST_METHOD'] === 'POST' )
			{	
				$input = $_POST;
				$conn = new mysqli($servername, $username, $password, $dbname);
				// Check connection
				if ($conn->connect_errno) 
				{
					$statusMessage = "Could not connect to database";
					echo($statusMessage);
				}
				else
				{
					if (isset($_POST["comment_id"]))
					{				
						echo("<br>We are deleting this comment now...");
						if ($stmt = $conn->prepare("DELETE FROM `comments` WHERE `comments`.`comment_id` =?"))					
						{
							$stmt->bind_param("i", $_POST["comment_id"]);
							if($stmt->execute())
							{
								echo("<br>Comment Deleted Successfully");
							}
							else
							{
								echo("<br>Comment Failed to Delete");
							}
						}	
						else
						{
							$error = $conn->errno . ' ' . $conn->error;
							echo $error; 
						}
						$stmt->close();
						
					}
					else
					{
						echo("<br>No id passed");
					}
				}
				if ($_POST["is_card"] == 1)
				{				
					echo ("<p><a href=\"./card-view.php?id=" . $_POST["id"] . "\">Back to the card</a></p>");	
					forceRedirect("./card-view.php?id=" . $_POST["id"]);
				}
				else
				{
					echo ("<p><a href=\"./deck-view.php?id=" . $_POST["id"] . "\">Back to the deck</a></p>");	
					forceRedirect("./deck-view.php?id=" . $_POST["id"]);
				}
				exit();
			}			
			else
			{
				$statusMessage = "No POST request received.";
			}
		?>
	</body>
</html>
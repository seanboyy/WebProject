<!-- do database stuff; redirect back to sending page -->
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Magic Maker - Add Comment</title>
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
				}
				else
				{
					echo("We are submitting your comment now...");
					$comment_id = 0;
					$conn->real_query("SELECT COUNT(*) FROM `comments`");
					$count_res = $conn->use_result();
					$count = $count_res->fetch_all(MYSQLI_NUM)[0];
					if($count > 0){
						$conn->real_query("SELECT max(comment_id) FROM `comments`");
						$comment_id_res = $conn->use_result();
						$comment_id = $comment_id_res->fetch_all(MYSQLI_NUM)[0];
					}
					$comment_id = $comment_id[0] + 1;

					if ($stmt = $conn->prepare("INSERT INTO `comments`(`comment_id`, `comment_text`, `user_id`, `post_id`, `is_card`) VALUES (?, ?, ?, ?, 1)"))					
					{
						$stmt->bind_param("isii", $comment_id, $input["comment_text"], $input["user"], $input["id"]);
						$stmt->execute();
					}	
					else
					{
						$error = $conn->errno . ' ' . $conn->error;
						echo $error; 
					}
				}
				$stmt->close();
				$conn->close();
				echo ("<p><a href=\"./card-view.php?id=" . $_POST["id"] . "\">Back to the card</a></p>");	
				forceRedirect("./card-view.php?id=" . $_POST["id"]);
			}			
			else
			{
				$statusMessage = "No POST request received.";
			}
		?>
	</body>
</html>
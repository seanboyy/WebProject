<!--  THIS FILE SHOULD ONLY BE CALLED IN A PHP FILE THAT HAS A CARD/DECK ID IN THE $_GET SUPERGLOBAL CALLED "id" -->
<!-- This creates a form that allows the user to add new comments -->
<form action="./card_comment_upload.php">
	<fieldset>
		<legend>New Comment</legend>
		<input type="textarea" rows="4" cols="25" placeholder="New Comment here!"></input>
		<input type="submit" value="Post Comment"></input>
	</fieldset>
</form>
<!-- This prints out existing comments -->
<?php
	$conn = mysqli_connect('localhost', 'root', '', 'card_database');	//This is very insecure
	if($conn->connect_errno){
		echo("Failed to connect to database.");
	}
	else{
		if ($stmt = $conn->prepare("SELECT comment_text, user_id FROM `comments` WHERE post_id = ? AND is_card = 1"))
		{
			$stmt->bind_param("i", $_GET["id"]);
			$stmt->execute();
			
			$res = $stmt->get_result();
			// If needed, check $res->num_rows
			if ($res->num_rows == 0)
			{
				echo ("<p>There are no comments for this card...maybe you can add one!</p>");	
			}
			else
			{
				$comments = array();
				while ($row = $res->fetch_assoc())
				{
					// Append a new associate array at the end of accounts
					$comments[] = array("comment_text" => $row["comment_text"], "user_id" => $row["user_id"]);
				}

				for($i = count($comments) - 1; $i >= 0; --$i)
				{
					// Find the user name for this comment
					$usrnmQryRslt = $conn->query("SELECT username FROM user_data WHERE user_id = " . $comments[$i]["user_id"]); // Note we're not preparing the query here; $comments[$i]["user_id"] is NOT user input, so we can trust in a pinch. In a more professional project, we should validate this data as well. 
					$username = "User 404";
					if ($usrnmQryRslt->num_rows > 0)
					{
						$username = $usrnmQryRslt->fetch_assoc()["username"];
					}
					echo(
						"<fieldset>" . 
							"<a href=./profile.php?id=" . $comments[$i]["user_id"] . "><h1>" . $username . " says: </h1></a>" .	// Create a link to the user profile
							"<p>" . $comments[$i]["comment_text"] . "</p>" .	//This should just be whatever the comment text is
						"</fieldset>"
					);
				}
			}
		}
		else
		{
			//$error = $conn->errno . ' ' . $conn->error;
			echo ("Could not load comments: " . $conn->error); 
		}
	}
?>
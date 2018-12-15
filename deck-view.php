<?php
	if (session_status() !== PHP_SESSION_ACTIVE) {
		session_start();
	}
	if(!isset($_SESSION["userid"]))
	{
		include "./redirect.php";
		forceRedirect("./login.html");
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<!-- use the same header as every other page, except the title is changed as appropriate --> 
		<title>Magic Maker - View Custom Deck</title>
		
		<link type="text/css" href="style.css" rel="stylesheet"/>
		<link rel="shortcut icon" href="icon.png"/>
				
		<script type="text/javascript" src="http://code.jquery.com/jquery-3.1.0.min.js"></script>
		<!--<script type="text/javascript" src="load-cards-on-scroll.js"></script>-->
		<script type="text/javascript" src="deck-main-script.js"></script>
		<script type="text/javascript" src="loadHeader.js"></script>
		
		<!-- For Bootstrap: -->
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link href="https://fonts.googleapis.com/css?family=Milonga" rel="stylesheet">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</head>
	<body>
		<!-- Header is dynamically loaded using AJAX-->
		<div id="header" class="row"></div>
		<div class="text-center">
		<?php
					
		?>
		</div>
		<div class="text-center">
		<?php
					$conn = mysqli_connect('localhost', 'root', '', 'card_database');
					if($conn->connect_errno)
					{
						echo("failed to connect!");
					}
					else
					{
						// Double check we have,  in fact, a deck we're displaying
						$result = $conn->query("SELECT creator_id, deck_id, points FROM `deck_database` WHERE deck_id = " . $_GET['id']);
						$deck = $result->fetch_all();	
						$_SESSION['creator_id'] = $deck[0][0];
						
						echo ("<input class=\"vote\" type='button' onclick='doUpvote(".$deck[0][1].")' value='Upvote'/>
								<p id='dpu".$deck[0][1]."'>".$deck[0][2]."</p>
								<input class=\"vote\" type='button' onclick='doDownvote(".$deck[0][1].")' value='Downvote'/>");
						
						$result2 = $conn->query("SELECT username FROM user_data WHERE user_id = " . $deck[0][0]);
						$deck2 = $result2->fetch_all();
						echo("<label for=\"creator_id\">Creator Name: </label>");
							//<!-- Pull deck name from database -->
							echo("<a href=\"other_profiles.php\"> " . $deck2[0][0] . "</a><br />");
						if ($deck[0][0]==$_SESSION['userid'] || $_SESSION['isadmin'] == 1)
						{
							echo("<input type='button' onclick='deleteDeck(".$_GET['id'].")' value='Delete Deck'>");
						}
					}
				?>
		</div>
		<?php
			$conn = mysqli_connect('localhost', 'root', '', 'card_database');
			if($conn->connect_errno)
			{
				echo("failed to connect!");
			}
			else
			{
				// Double check we have,  in fact, a deck we're displaying
				$result = $conn->query("SELECT * FROM `deck_database` WHERE deck_id = " . $_GET['id']);
				$deck = $result->fetch_all();	
				if (count($deck) == 0)
				{
					echo("<p>Error 404 - No Deck Found</p>");
				}
				else
				{
					echo("<p class=\"text-center title\">".$deck[0][4]."</p>");
					echo("<div class=\"deckView\">");
					$deckList = explode(' ', $deck[0][1]);
					for ($i = 0; $i < count($deckList); $i++) {
						echo("<img class=\"cardFormat\" src=\"".$deckList[$i]."\"/>");
					}
					echo("</div>");
					echo("<p class=\"text-center\">".$deck[0][2]."</p>");
					include "./deck_comments.php";
				}
			}
		?>
	</body>
</html>
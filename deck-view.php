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
		<script type="text/javascript" src="load-cards-on-scroll.js"></script>
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
		<div>
		<?php
					$conn = mysqli_connect('localhost', 'root', '', 'card_database');
					if($conn->connect_errno)
					{
						echo("failed to connect!");
					}
					else
					{
						// Double check we have,  in fact, a deck we're displaying
						$result = $conn->query("SELECT (creator_id) FROM `deck_database` WHERE deck_id = " . $_GET['id']);
						$deck = $result->fetch_all();	
						$_SESSION['creator_id'] = $deck[0][0];
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
				// Double check we have,  in fact, a card we're displaying
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
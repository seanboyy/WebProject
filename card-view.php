<!DOCTYPE html>
<html>
	<head>
		<!-- use the same header as every other page, except the title is changed as appropriate --> 
		<title>Magic Maker - View Custom Card</title>
		
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

		<!-- Pull card information from database -->
		<?php
		
		?>
		
		<div class="row">
			<div class="col-sm-2 text-center">
			</div>
			<div class="col-sm-3 text-center">
				<div class="cardImageDisplay">
					<?php
						$conn = mysqli_connect('localhost', 'root', '', 'card_database');
						if($conn->connect_errno)
						{
							echo("failed to connect!");
						}
						else
						{
							$result = $conn->query("SELECT card_image FROM `custom_cards` WHERE card_id = " . $_GET['id']);
							// For some reason, our card is an array within an array, so...
							$card = $result->fetch_all()[0];	
							echo("<img src=\"" . $card[0] . "\"alt=" . $_GET['id'] . "/>");
						}
					?>
					<!-- Pull card image path from database -->
				</div>
			</div>
			<div class="col-sm-7 text-center">
				<?php
					$conn = mysqli_connect('localhost', 'root', '', 'card_database');
					if($conn->connect_errno)
					{
						echo("failed to connect!");
					}
					else
					{
						$result = $conn->query("SELECT * FROM `custom_cards` WHERE card_id = " . $_GET['id']);
						// For some reason, our card is an array within an array, so...
						$card = $result->fetch_all()[0];
						
						echo("<label for=\"card-name\">Card Name: </label>");
						//<!-- Pull card name from database -->
						echo(" " . $card[1] . "<br />");
						echo("<label for=\"mana-cost\">Mana Cost: </label>");
						//<!-- Pull mana cost from database -->
						echo(" " . $card[2] . "<br />");
						echo("<label for=\"type-line\">Type Line: </label>");
						//<!-- Pull type line from database -->
						echo(" " . $card[3] . "<br />");
						echo("<label for=\"rarity\">Rarity: </label>");	
						//<!-- Pull rarity from database -->
						switch ($card[4])
						{
							case 2:
								echo(" Token <br />");
								break;
							case 3:
								echo(" Basic Land <br />");
								break;
							case 4:
								echo(" Common <br />");
								break;
							case 5:
								echo(" Uncommon <br />");
								break;
							case 6:
								echo(" Rare <br />");
								break;
							case 7: 
								echo(" Mythic Rare <br />");
								break;
						}
						echo("<label for=\"rules-text\">Rules Text:</label>");
						//<!-- Pull rules text from database (may be multiple lines) -->
						echo(" " . $card[5] . "<br />");
						echo("<label for=\"power\">Power/Toughness: </label>");
						//<!-- Pull power from database -->
						//<!-- Pull toughness from database -->
						echo(" " . $card[6] . "/");
						echo($card[7] . "<br />");
						echo("<label for=\"description\">Card Description:</label>");
						//<!-- Pull card description from database -->
						echo(" " . $card[9] . "<br />");
					}
				?>
			</div>
		</div>
		<!-- We should display comments here, I guess? How are we implementing comments? -->
	</body>
</html>
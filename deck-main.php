<!DOCTYPE html>
<html lang="en-us">
	<head>
		<meta charset="utf-8">
		<title>Magic Maker</title>
		<link type="text/css" href="style.css" rel="stylesheet"/>
		<link rel="shortcut icon" href="icon.png"/>
		<script type="text/javascript" src="http://code.jquery.com/jquery-3.1.0.min.js"></script>
		
		<!--<script type="text/javascript" src="load-cards-on-scroll.js"></script> -->
		<!--<script type="text/javascript" src="deck-card-seach.js"></script>-->
		<script type="text/javascript" src="loadHeader.js"></script>
		<!--To run the drag and drop-->
		<!--<script type="text/javascript" src="drag-drop.js"></script>-->
		
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
			$conn = new mysqli("127.0.0.1", "root", "", "card_database");
			$statusMessage = "";
			// Check connection
			if ($conn->connect_errno) {
				$statusMessage = "Could not connect to database";
			} else
			{
				$result = $conn->query("SELECT title, deck_id, cards FROM deck_database");
				$reversed = array_reverse($result->fetch_all());
				for($i = 0; $i < count($reversed); $i++)
				{
					echo ("<span>".$reversed[$i][0]."<a href='./deck-view.php?id=" . $reversed[$i][1] . "'><img alt='" .
					$reversed[$i][1] . "' src='" . explode(' ', $reversed[$i][2])[0] . "' class='cardFormat'/></a></span>");
				}
			}
		?>
		</div>
	</body>
</html>
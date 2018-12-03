<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<!-- use the same header as every other page, except the title is changed as appropriate --> 
		<title>Magic Maker - Upload Custom Card</title>
		
		<link type="text/css" href="style.css" rel="stylesheet"/>
		<link rel="shortcut icon" href="icon.png"/>
				
		<script type="text/javascript" src="http://code.jquery.com/jquery-3.1.0.min.js"></script>
		<script type="text/javascript" src="load-profile-info.js"></script>
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

		<div class="row">
				
			<div class="col-sm-4 text-center rightLine">
				<!--<p>
				<div class="profileImageDisplay">
					<img alt="profile Image"/>
				</div>
				<p/>
				<p>Username</p>				
				<p>Cards Created: </p>
				<p>Decks Created: </p>
				<p>Total Upvotes: </p>
				-->
				<?php
			$servername = "127.0.0.1";
			$username = "root";
			$password = "";
			$dbname = "user_data";

			// These hold the values we will output in the JSON
			$statusMessage = "";

			// Check that we received a POST request
			if( $_SERVER['REQUEST_METHOD'] === 'POST' )
			{	
				if(!isset($_POST["username"]) || !is_string($_POST["username"])) {}
				if(!isset($_POST["points"]) || !is_int($_POST["points"])) {}
				
				$conn = new mysqli($servername, $username, $password, $dbname);
				// Check connection
				if ($conn->connect_errno) 
				{
					$statusMessage = "Could not connect to database";
				}
				else
				{
					$userId = 0;
					$conn->real_query("SELECT COUNT(*) FROM `user_data`");
					$count_res = $conn->use_result();
					$count = $count_res->fetch_all(MYSQLI_NUM)[0];
					if($count > 0){
						$conn->real_query("SELECT max(user_id) FROM `user_data`");
						$cardid_res = $conn->use_result();
						$cardid = $cardid_res->fetch_all(MYSQLI_NUM)[0];
					}
					$userId[0]++;
					$userid = -1;
					$stmt = $conn->prepare("INSERT INTO `user_data` VALUES (?, ?)");
					$stmt->bind_param("si", $cardid[0], $_POST["username"], $_POST["points"]);
					$stmt->execute();
				}
			}
			
			
		?>
			</div>
			
			<div class="col-xs-4 text-center">
				<p>Decks</p>
				<div id="deckList"></div>
			</div>
			<div class="col-xs-4 text-center leftLine">
				<p>Cards</p>
				<div id="cardList"></div>
			</div>
		</div>
	</body>
</html>
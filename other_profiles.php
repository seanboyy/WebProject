<?php
	session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<!-- use the same header as every other page, except the title is changed as appropriate --> 
		<title>Magic Maker - Other User Profiles</title>
		
		<link type="text/css" href="style.css" rel="stylesheet"/>
		<link rel="shortcut icon" href="icon.png"/>
				
		<script type="text/javascript" src="http://code.jquery.com/jquery-3.1.0.min.js"></script>
		<script type="text/javascript" src="load-profile-info.js"></script>
		<script type="text/javascript" src="loadHeader.js"></script>
		<script type="text/javascript" src="admin_button.js"></script>
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
			$dbname = "card_database";
			
			// These hold the values we will output in the JSON
			$statusMessage = "";
			$userId = $_SESSION["creator_id"];
			$myID = $_SESSION["userid"];
			// Check that we received a GET request
			if( $_SERVER['REQUEST_METHOD'] === 'GET' )
			{					
				$conn = new mysqli($servername, $username, $password, $dbname);
				// Check connection
				if ($conn->connect_errno) 
				{
					$statusMessage = "Could not connect to database";
				}
				else
				{
					$points = $conn->query("SELECT points FROM user_data WHERE user_id = '$userId'");
					$Points = $points->fetch_all()[0];
					$actualPoints1 = $conn->query("SELECT SUM(points) FROM custom_cards WHERE creator_id ='$userId'")->fetch_assoc();
					if (count($actualPoints1) == 0)
					{
						$actualPoints1["SUM(points)"] = 0;
						echo("There are no points associated with this user from custom cards.");
					}
					//$ActualPoints1 = actualPoints1->fetch_all()[1];
					$actualPoints2 = $conn->query("SELECT SUM(points) FROM deck_database WHERE creator_id ='$userId'")->fetch_assoc();
					if (count($actualPoints2) == 0)
					{
						$actualPoints2["SUM(points)"] = 0;
						echo("There are no points associated with this user from custom decks.");
					}
					//$ActualPoints2 = actualPoints2->fetch_all()[1];
					$actualPoints = $actualPoints1["SUM(points)"]+$actualPoints2["SUM(points)"];
					if($Points[0] != $actualPoints){
						$adminUpdate = $conn->query("UPDATE user_data SET points='$actualPoints' WHERE user_id =". $userId);
					}
					//SELECT SUM(points) FROM deck_database WHERE creator_id = 3
					//SELECT SUM(points) FROM custom_cards WHERE creator_id = 3
					$result = $conn->query("SELECT username, points FROM user_data WHERE user_id = '$userId'");
					$userInfo = $result->fetch_all()[0];
					echo("Username: " . $userInfo[0] . "<br />Points: " . $userInfo[1]);
					// Multiple Queries will be needed:
					// SELECT username, points FROM user_data
					// SELECT card_id, card_image FROM custom_card WHERE creator_id = $userId
					// SELECT deck_id FROM deck_database WHERE creator_id = $userId
					$adminStatus1 = $conn->query("SELECT is_admin FROM user_data WHERE user_id = '$myID'");
					$adminMe = $adminStatus1->fetch_all()[0];
					$adminStatus2 = $conn->query("SELECT is_admin FROM user_data WHERE user_id = '$userId'");
					$adminThem = $adminStatus2->fetch_all()[0];
					if($adminMe[0] == 1 && $adminThem[0] == 0){
						 echo("<div></div><input type='button' onclick='makeAdmin(".$userId.")' value='Make Admin'><br />");
						 
					}
				}	
			}
			
			
		?>
			</div>
			
			<div class="col-xs-4 text-center">
				<p>Decks</p>
				<!-- PHP QUERY FOR DECKS -->
				<?php
					$conn = new mysqli("127.0.0.1", "root", "", "card_database");
					$statusMessage = "";
					$userId = $_SESSION["creator_id"];
					//promote user to admin
					$myID = $_SESSION["userid"];
					
					// Check connection
					if ($conn->connect_errno) 
					{
						$statusMessage = "Could not connect to database";
					}
					else
					{
						
						$result = $conn->query("SELECT title, deck_id, cards FROM deck_database WHERE creator_id = '$userId'");
						$reversed = array_reverse($result->fetch_all());
						for($i = 0; $i < count($reversed); $i++)
						{
							echo ("<div><p>".$reversed[$i][0]."</p><a href='./deck-view.php?id=" . $reversed[$i][1] . "'><img alt='" .
							$reversed[$i][1] . "' src='" . explode(' ', $reversed[$i][2])[0] . "' class='cardFormat'/></a></div>");
						}
						$adminMe = $conn->query("SELECT username, points FROM user_data WHERE user_id = '$userId'");
					}
					
				?>
				
			</div>
			<div class="col-xs-4 text-center leftLine">
				<p>Cards</p>
				<!-- PHP QUERY FOR CARDS -->
				<?php
					$userId = $_SESSION["creator_id"];
					$result = $conn->query("SELECT card_id, card_image FROM custom_cards WHERE creator_id = '$userId'");
					$reversed = array_reverse($result->fetch_all());
					for($i = 0; $i < count($reversed); ++$i){
						echo "<div> <a href='./card-view.php?id=".$reversed[$i][0]."'><img alt='".$reversed[$i][0]."' src='".$reversed[$i][1]."' class='cardFormat'/></a></div>";
					}
				?>
			</div>
		</div>
	</body>
</html>
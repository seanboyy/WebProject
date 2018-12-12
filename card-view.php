<?php
	session_start();
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
							$imgQry = $conn->prepare("SELECT card_image FROM `custom_cards` WHERE card_id = ?");
							$imgQry->bind_param("i", $_GET["id"]);
							$imgQry->execute();
							$res = $imgQry->get_result();	
							if ($res->num_rows <= 0)
							{
								echo("<p>Error 404 - No Card Found</p>");
							}
							else
							{
								$card = $res->fetch_assoc();
								echo("<img class=\"cardImageDisplay\" src=\"" . $card["card_image"] . "\"alt=" . $_GET['id'] . "/>");
							}
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
						// Double check we have,  in fact, a card we're displaying
						$result = $conn->query("SELECT (creator_id) FROM `custom_cards` WHERE card_id = " . $_GET['id']);
						$card = $result->fetch_all();	
						$_SESSION['creator_id'] = $card[0][0];
						$result2 = $conn->query("SELECT username FROM user_data WHERE user_id = " . $card[0][0]);
						$card2 = $result2->fetch_all();
						echo("<label for=\"creator_id\">Creator Name: </label>");
						//<!-- Pull card name from database -->
						echo("<a href=\"other_profiles.php\"> " . $card2[0][0] . "</a><br />");
					}
				?>
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
						$card = $result->fetch_all();
						if(count($card) == 0)
						{
							echo("<p>Error 404 - No Card Found</p>");							
						}
						else
						{
							$pattern = "' '";
							$card = $card[0];
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
							if ($card[6] != -101 && $card[7] != -101)
							{
								echo("<label for=\"power\">Power/Toughness: </label>");
								//<!-- Pull power from database -->
								//<!-- Pull toughness from database -->
								echo(" " . $card[6] . "/");
								echo($card[7] . "<br />");
							}
							echo("<label for=\"description\">Card Description:</label>");
							//<!-- Pull card description from database -->
							echo(" " . $card[9] . "<br />");
							// Display a button to edit the card if it belongs to the user
							if ($card[8] == $_SESSION["userid"] || $_SESSION['isadmin'] == 1)
							{
								echo(	"<form method=\"POST\" action=\"card-upload.php\" enctype=\"multipart/form-data\">" .
										"<input type=\"hidden\" name=\"card-id\" value=" . $card[0] . "\"/>"	.	
										"<input type=\"hidden\" name=\"card-img\" value=" . $card[10] . "\"/>" .	
										"<input type=\"hidden\" name=\"card-name\" value=" . $card[1] . "\"/>" .
										"<input type=\"hidden\" name=\"mana-cost\" value=" . $card[2] . "\"/>" .
										"<input type=\"hidden\" name=\"type-line\" value=" . $card[3] . "\"/>" .	
										"<input type=\"hidden\" name=\"rarity\" value=" . $card[4] . "\"/>" .	
										"<input type=\"hidden\" name=\"rules-text\" value=\"" . preg_replace($pattern, "%20", $card[5]) . "\"/>" .	
										"<input type=\"hidden\" name=\"power\" value=" . $card[6] . "\"/>" .
										"<input type=\"hidden\" name=\"toughness\" value=" . $card[7] . "\"/>" . 
										"<input type=\"hidden\" name=\"description\" value=\"" . preg_replace($pattern, "%20", $card[9]) . "\"/>" .
										"<input type=\"submit\" value=\"Edit Card\"/>" . 
										"</form>");
							}		
							if ($card[0][0]==$_SESSION['userid'] || $_SESSION['isadmin'] == 1)
							{
								echo("<input type='button' onclick='deleteCard(".$_GET['id'].")' value='Delete Card'><br />");
							}
						}
					}
					echo "</div>";
					echo "<table>
							<tbody>
								<tr>
									<td class='upvoteButton'>
										<input class=\"vote\" type='button' onclick='doUpvote(".$_GET['id'].")' value='Upvote'>
									</td>
									<td id='mpp".$_GET['id']."'>"
											.$conn->query("SELECT points FROM `custom_cards` WHERE card_id = ".$_GET['id'])->fetch_all()[0][0].
									"</td>
									<td class='downvoteButton'>
										<input class=\"vote\" type='button' onclick='doDownvote(".$_GET['id'].")' value='Downvote'>
									</td>
								</tr>
							</tbody>
						</table>";
				?>
		</div>
		<!-- display comments -->
		<?php
			$conn = mysqli_connect('localhost', 'root', '', 'card_database');
			if($conn->connect_errno)
			{
				echo("failed to connect!");
			}
			else
			{
				// Double check we have,  in fact, a card we're displaying
				$result = $conn->query("SELECT * FROM `custom_cards` WHERE card_id = " . $_GET['id']);
				$card = $result->fetch_all();	
				if (count($card) == 0)
				{
					echo("<p>Error 404 - No Card Found</p>");
				}
				else
				{
					include "./card_comments.php";
				}
			}
		?>
	</body>
</html>
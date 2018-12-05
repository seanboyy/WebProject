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
		<title>Magic Maker - Upload Custom Card</title>
		
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
					<img alt="Card Image"/>
				</div>
			</div>
			<div class="col-sm-7 text-center">
				<?php
					if (isset($_POST["card-id"]))
					{
						$pattern = "' '";
						$editForm = 	"<form method=\"POST\" action=\"upload-card.php\" enctype=\"multipart/form-data\">" .
										"<input type=\"hidden\" name=\"card-id\" value=\"" . $_POST["card-id"] . "\"/>" .  
										// Uploading the card might be tricky... we'll skip it for now...
										"<label for=\"f-card-img\">Card Image: </label>" .
										"<input class=\"center\" type=\"file\" name=\"card-img\" id=\"f-card-img\"/><br />" .
										// End card image upload
										"<label for=\"f-card-name\">Card Name: </label>" . 
										"<input type=\"text\" name=\"card-name\" id=\"f-card-name\" value=\"" . $_POST["card-name"] . "\"/><br />" . 	
										"<label for=\"f-mana-cost\">Mana Cost: </label>" . 
										"<input type=\"text\" name=\"mana-cost\" id=\"f-mana-cost\" value=\"" . $_POST["mana-cost"] . "\"/><br />" . 
										"<label for=\"f-type-line\">Type Line: </label>" . 
										"<input type=\"text\" name=\"type-line\" id=\"f-type-line\" value=\"" . $_POST["type-line"] . "\"/><br />" .	
										"<label for=\"f-rarity\">Rarity: </label>" . 	
										"<select name=\"rarity\" id=\"f-rarity\">";
						// I can't believe I'm about to do this just to get this dumb selection right...	
						switch($_POST["rarity"])
						{
							case 1:
									$editForm = $editForm . "<option value=\"1\" selected>--Not Selected--</option>" . 
															"<option value=\"2\">Token</option>" . 
															"<option value=\"3\">Basic Land</option>" . 
															"<option value=\"4\">Common</option>" . 
															"<option value=\"5\">Uncommon</option>" .
															"<option value=\"6\">Rare</option>" .
															"<option value=\"7\">Mythic Rare</option>";
									break;
							case 2:
									$editForm = $editForm . "<option value=\"1\">--Not Selected--</option>" . 
															"<option value=\"2\" selected>Token</option>" . 
															"<option value=\"3\">Basic Land</option>" . 
															"<option value=\"4\">Common</option>" . 
															"<option value=\"5\">Uncommon</option>" .
															"<option value=\"6\">Rare</option>" .
															"<option value=\"7\">Mythic Rare</option>";
									break;
							case 3:
									$editForm = $editForm . "<option value=\"1\">--Not Selected--</option>" . 
															"<option value=\"2\">Token</option>" . 
															"<option value=\"3\" selected>Basic Land</option>" . 
															"<option value=\"4\">Common</option>" . 
															"<option value=\"5\">Uncommon</option>" .
															"<option value=\"6\">Rare</option>" .
															"<option value=\"7\">Mythic Rare</option>";
									break;
							case 4: 
									$editForm = $editForm . "<option value=\"1\">--Not Selected--</option>" . 
															"<option value=\"2\">Token</option>" . 
															"<option value=\"3\">Basic Land</option>" . 
															"<option value=\"4\" selected>Common</option>" . 
															"<option value=\"5\">Uncommon</option>" .
															"<option value=\"6\">Rare</option>" .
															"<option value=\"7\">Mythic Rare</option>";
									break;
							case 5:
									$editForm = $editForm . "<option value=\"1\">--Not Selected--</option>" . 
															"<option value=\"2\">Token</option>" . 
															"<option value=\"3\">Basic Land</option>" . 
															"<option value=\"4\">Common</option>" . 
															"<option value=\"5\" selected>Uncommon</option>" .
															"<option value=\"6\">Rare</option>" .
															"<option value=\"7\">Mythic Rare</option>";
									break;
							case 6: 
									$editForm = $editForm . "<option value=\"1\">--Not Selected--</option>" . 
															"<option value=\"2\">Token</option>" . 
															"<option value=\"3\">Basic Land</option>" . 
															"<option value=\"4\">Common</option>" . 
															"<option value=\"5\">Uncommon</option>" .
															"<option value=\"6\" selected>Rare</option>" .
															"<option value=\"7\" >Mythic Rare</option>";
									break;
							case 7:
									$editForm = $editForm . "<option value=\"1\">--Not Selected--</option>" . 
															"<option value=\"2\">Token</option>" . 
															"<option value=\"3\">Basic Land</option>" . 
															"<option value=\"4\">Common</option>" . 
															"<option value=\"5\">Uncommon</option>" .
															"<option value=\"6\">Rare</option>" .
															"<option value=\"7\" selected>Mythic Rare</option>";
									break;
						};
									
						$editForm = $editForm . "</select><br />" . 	
										"<label for=\"f-rules-text\">Rules Text:</label>" . 
										"<textarea id=\"f-rules-text\" name=\"rules-text\" rows=\"3\" cols=\"25\">" . preg_replace("\"%20\"", " ", $_POST["rules-text"]) . "</textarea><br />" . 	
										"<label for=\"f-power\">Power/Toughness: </label>" ;
						if ($_POST["power"] != -58)
						{
							$editForm = $editForm . "<input class=\"smallInput\" type=\"number\" name=\"power\" id=\"f-power\" min=\"-100\" value=\"" . $_POST["power"] . "\"/>";
						}
						else
						{
							$editForm = $editForm . "<input class=\"smallInput\" type=\"number\" name=\"power\" id=\"f-power\" min=\"-100\"/>";
							
						}
						if ($_POST["toughness"] != -58)
						{
							$editForm = $editForm . "<input class=\"smallInput\" type=\"number\" name=\"toughness\" id=\"f-toughness\" min=\"-100\" value=\"" . $_POST["toughness"] . "\"/><br />";
						}
						else
						{
							$editForm = $editForm . "<input class=\"smallInput\" type=\"number\" name=\"toughness\" id=\"f-toughness\" min=\"-100\"/><br />";
						}			
						$editForm = $editForm . "<label for=\"f-description\">Card Description:</label>" . 
										"<textarea id=\"f-description\" name=\"description\" rows=\"4\" cols=\"25\" placeholder=\"Give a short description of your thought process in creating this card. This is entirely optional.\">" .preg_replace("\"%20\"", " ", $_POST["description"]) . "</textarea><br />" . 
										"<input class=\"smallInput\" type=\"submit\" value=\"Update Card\" />" . 
										"</form>";

						echo($editForm);
					}
					else
					{
						echo ("<form method=\"POST\" action=\"upload-card.php\" enctype=\"multipart/form-data\">" .
								"<label for=\"f-card-img\">Card Image: </label>" .
								"<input class=\"center\" type=\"file\" name=\"card-img\" id=\"f-card-img\"/><br />" .	
								"<label for=\"f-card-name\">Card Name: </label>" . 
								"<input type=\"text\" name=\"card-name\" id=\"f-card-name\"/><br />" . 	
								"<label for=\"f-mana-cost\">Mana Cost: </label>" . 
								"<input type=\"text\" name=\"mana-cost\" id=\"f-mana-cost\"/><br />" . 
								"<label for=\"f-type-line\">Type Line: </label>" . 
								"<input type=\"text\" name=\"type-line\" id=\"f-type-line\"/><br />" .	
								"<label for=\"f-rarity\">Rarity: </label>" . 	
								"<select name=\"rarity\" id=\"f-rarity\">" . 
									"<option value=\"1\">--Not Selected--</option>" . 
									"<option value=\"2\">Token</option>" . 
									"<option value=\"3\">Basic Land</option>" . 
									"<option value=\"4\">Common</option>" . 
									"<option value=\"5\">Uncommon</option>" .
									"<option value=\"6\">Rare</option>" .
									"<option value=\"7\">Mythic Rare</option>" . 
								"</select><br />" . 	
								"<label for=\"f-rules-text\">Rules Text:</label>" . 
								"<textarea id=\"f-rules-text\" name=\"rules-text\" rows=\"3\" cols=\"25\"></textarea><br />" . 	
								"<label for=\"f-power\">Power/Toughness: </label>" . 
								"<input class=\"smallInput\" type=\"number\" name=\"power\" id=\"f-power\" min=\"-100\"/>" . 
								"<input class=\"smallInput\" type=\"number\" name=\"toughness\" id=\"f-toughness\" min=\"-100\"/><br />" . 
								"<label for=\"f-description\">Card Description:</label>" . 
								"<textarea id=\"f-description\" name=\"description\" rows=\"4\" cols=\"25\" placeholder=\"Give a short description of your thought process in creating this card. This is entirely optional.\"></textarea><br />" . 
								"<input class=\"smallInput\" type=\"submit\" value=\"Submit Card\" />" . 
							"</form>");
					}
				?>
			</div>
		</div>
	</body>
</html>
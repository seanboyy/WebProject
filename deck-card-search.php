<html>
	<head>
	</head>
	<body>
		<?php
			$conn = mysqli_connect('localhost', 'root', '', 'card_database');
			if($conn->connect_errno){
				echo("failed to connect!");
			}
			else{
				$search = $_GET["q"];
				if (strlen($search) > 0) {
					$result = $conn->query("SELECT card_id, card_image FROM `custom_cards` WHERE card_name LIKE \"%" . strtolower($search) . "%\"");
					$reversed = array_reverse($result->fetch_all());
					for($i = 0; $i < count($reversed); ++$i){
						echo '<img id="'.$reversed[$i][1].'" draggable="true" ondragstart="drag(event)" alt="cardImage" src="'.$reversed[$i][1].'" class="cardFormat"/>';
						//echo "<span id='cococardso' onmouseenter='doEntry(".$reversed[$i][0].", this)' onmouseleave='doLeave(this)'><a href='./card-view.php?id=".$reversed[$i][0]."'><img alt='".$reversed[$i][0]."' src='".$reversed[$i][1]."' class='cardFormat'/></a></span>";
					}
					
					$result = $conn->query("SELECT card_id, card_image FROM `custom_cards` WHERE card_name LIKE \"%" . strtoupper($search) . "%\"");
					$reversed = array_reverse($result->fetch_all());
					for($i = 0; $i < count($reversed); ++$i){
						echo '<img id="'.$reversed[$i][1].'" draggable="true" ondragstart="drag(event)" alt="cardImage" src="'.$reversed[$i][1].'" class="cardFormat"/>';
						//echo "<span id='cococardso' onmouseenter='doEntry(".$reversed[$i][0].", this)' onmouseleave='doLeave(this)'><a href='./card-view.php?id=".$reversed[$i][0]."'><img alt='".$reversed[$i][0]."' src='".$reversed[$i][1]."' class='cardFormat'/></a></span>";
					}
				}
			}
		?>
	</body>
</html>
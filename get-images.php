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
				$result = $conn->query("SELECT card_id, card_image FROM `custom_cards` ");
				$reversed = array_reverse($result->fetch_all());
				for($i = 0; $i < count($reversed); ++$i){
					echo "<span onmouseenter='doEntry(".$reversed[$i][0].", this)' onmouseleave='doLeave()'><a href='./card-view.php?id=".$reversed[$i][0]."'><img alt='".$reversed[$i][0]."' src='".$reversed[$i][1]."' class='cardFormat'/></a></span>";
				}
			}
		?>
	</body>
</html>
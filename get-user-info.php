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
				$result = $conn->query("SELECT `card_image` FROM `custom_cards`");
				$reversed = array_reverse($result->fetch_all());
				for($i = 0; $i < count($reversed); ++$i){
					echo "<img alt='".$reversed[$i][0]."' src='".$reversed[$i][0]."' class='cardFormat'/>";
				}
			}
		?>
	</body>
</html>
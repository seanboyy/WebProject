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
				$search = $_GET["id"];
				if (strlen($search) > 0) {
					$result = $conn->query("DELETE FROM `custom_cards` WHERE card_id = ". $search);
				}
			}
		?>
	</body>
</html>
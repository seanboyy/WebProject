<html>
	<head>
	</head>
	<body>
		<?php
			//session_start();
	
			
				$conn =  mysqli_connect('localhost', 'root', '', 'card_database');
				// Check connection
				if ($conn->connect_errno) 
				{
					$statusMessage = "Could not connect to database";
				}
				else
				{
					$search = $_GET["id"];	
					
					//if (strlen($search) > 0) {
						$adminUpdate = $conn->query("UPDATE user_data SET is_admin=1 WHERE user_id =". $search);
					//}	
					
				}
				
		?>
</body>
</html>
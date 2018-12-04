<?php
	//$session_reset();
	define('DB_SERVER','localhost');
	define('DB_USER','root');
	define('DB_PASS', '');
	define('DB_NAME', 'card_database');

	$conn = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);

	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	
	if(isset($_POST["username"], $_POST["password"], $_POST["password-confirm"], $_POST["email"])) 
    {     

        $name = $_POST["username"]; 
        $password = $_POST["password"]; 
		$passwordC = $_POST["password-confirm"];
		$email = $_POST["email"];
		
		if($password === $passwordC){
			
			if ($conn->real_query("SELECT max(user_id) FROM `user_data`") === TRUE) {
				$cardid_res = $conn->use_result();
				$userid = $cardid_res->fetch_all(MYSQLI_NUM)[0];
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
			
			$userid[0]++;
			
			$sql = "INSERT INTO user_data VALUES ('$userid[0]','$name', '$email', '$password', 0, 0)" ;

			if ($conn->query($sql) === TRUE) {
				include 'accountCreated.php';
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
		}
		
		else{
			echo "Passwords do not match!";
			echo '<br></br><a href="login.html">Please try creating an account again</a>';
		}
	}
	
	$conn->close();
?>
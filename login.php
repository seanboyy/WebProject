
<?php
	define('DB_SERVER','localhost');
	define('DB_USER','root');
	define('DB_PASS', '');
	define('DB_NAME', 'card_database');

	$conn = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);

	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	
	if(isset($_POST["username"], $_POST["password"])) 
    {     

        $name = $_POST["username"]; 
        $password = $_POST["password"]; 

        $result1 = mysqli_query($conn, "SELECT username, password FROM user_data WHERE username = '$name' AND password = '$password'");

        if(mysqli_num_rows($result1) > 0 )
        { 
			session_start([
				//'cookie_lifetime' => 86400,
			]);
			
			$result1 = mysqli_query($conn, "SELECT user_id FROM user_data WHERE username = '$name' AND password = '$password'");
            $row = mysqli_fetch_array($result1);
			$id = $row['user_id'];
			
			$result1 = mysqli_query($conn, "SELECT is_admin FROM user_data WHERE username = '$name' AND password = '$password'");
			$row = mysqli_fetch_array($result1);
			$admin_check = $row['is_admin'];
			
			if($admin_check == 1){
				$_SESSION["logged_in"] = true; 
				$_SESSION["isadmin"] = 1;
				$_SESSION["userid"] = $id;
			}
			
			else{
				$_SESSION["logged_in"] = true; 
				$_SESSION["isadmin"] = 0;
				$_SESSION["userid"] = $id; 
			}
			
			include 'index.html';
        }
        else
        {
            echo 'The username or password are incorrect!';
			echo '<br></br><a href="login.html">Return to the Login Page</a>';
        }
	}
	
	$conn->close();
?>
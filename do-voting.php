<?php
	if (session_status() !== PHP_SESSION_ACTIVE) {
		session_start();
	}
	if(!isset($_SESSION["userid"])) {
		include "./redirect.php";
		forceRedirect("./login.html");
	}
?>
<!DOCTYPE html>
<html>
<head></head>
<body>
<?php
	$conn = mysqli_connect('localhost', 'root', '', 'card_database');
	$type = $_GET['type'] === "card" ? "`custom_cards`" : ( $_GET['type'] === "deck" ? "`deck_database`" :  "");
	$id = $_GET['type'] === "card" ? "`card_id`" : ( $_GET['type'] === "deck" ? "`deck_id`" : "");
	if($conn->connect_errno) {
		echo("failed to connect!");
	}
	else {
		$result = $conn->query("SELECT `upvoters`, `downvoters` FROM ".$type." WHERE ".$id." = ".$_GET['id'])->fetch_all();
		$upvoters = explode(" ", $result[0][0]);
		$downvoters = explode(" ", $result[0][1]);
		$i = 0;
		$j = 0;
		$upresult = FALSE;
		$downresult = FALSE;
		for(; $i < count($upvoters); ++$i) if($upvoters[$i] == $_SESSION['userid']) break;
		for(; $j < count($downvoters); ++$j) if($downvoters[$j] == $_SESSION['userid']) break;
		if($i < count($upvoters)){
			$upresult = TRUE;
		}
		if($j < count($downvoters)){
			$downresult = TRUE;
		}
		if(isset($_GET['isUpvoting'])) {
			if($upresult === TRUE){
				$conn->query("UPDATE ".$type." SET `points` = `points` - 1 WHERE ".$id." = ".$_GET['id']);
				unset($upvoters[$i]);
				$_upvoters = array_values($upvoters);
				$_result = implode(" ", $_upvoters);
				$conn->query("UPDATE ".$type." SET `upvoters` = \"".$_result."\" WHERE ".$id." = ".$_GET['id']);
			}
			else if($downresult === TRUE){
				$conn->query("UPDATE ".$type." SET `points` = `points` + 2 WHERE ".$id." = ".$_GET['id']);
				array_push($upvoters, $_SESSION['userid']);
				$_result = implode(" ", $upvoters);
				$conn->query("UPDATE ".$type." SET `upvoters` = \"".$_result."\" WHERE ".$id." = ".$_GET['id']);
				unset($downvoters[$j]);
				$_downvoters = array_values($downvoters);
				$__result = implode(" ", $_downvoters);
				$conn->query("UPDATE ".$type." SET `downvoters` = \"".$__result."\" WHERE ".$id." = ".$_GET['id']);
			}
			else{
				$conn->query("UPDATE ".$type." SET `points` = `points` + 1 WHERE ".$id." = ".$_GET['id']);
				array_push($upvoters, $_SESSION['userid']);
				$_result = implode(" ", $upvoters);
				$conn->query("UPDATE ".$type." SET `upvoters` = \"".$_result."\" WHERE ".$id." = ".$_GET['id']);
			}
		}
		else if(isset($_GET['isDownvoting'])) {
			if($upresult === TRUE) {
				$conn->query("UPDATE ".$type." SET `points` = `points` - 2 WHERE ".$id." = ".$_GET['id']);
				unset($upvoters[$i]);
				$_upvoters = array_values($upvoters);
				$_result = implode(" ", $_upvoters);
				$conn->query("UPDATE ".$type." SET `upvoters` = \"".$_result."\" WHERE ".$id." = ".$_GET['id']);
				array_push($downvoters, $_SESSION['userid']);
				$__result = implode(" ", $downvoters);
				$conn->query("UPDATE ".$type." SET `downvoters` = \"".$__result."\" WHERE ".$id." = ".$_GET['id']);
			}
			else if($downresult === TRUE) {
				$conn->query("UPDATE ".$type." SET `points` = `points` + 1 WHERE ".$id." = ".$_GET['id']);
				unset($downvoters[$j]);
				$_downvoters = array_values($downvoters);
				$_result = implode(" ", $_downvoters);
				$conn->query("UPDATE ".$type." SET `downvoters` = \"".$_result."\" WHERE ".$id." = ".$_GET['id']);
			}
			else{
				$conn->query("UPDATE ".$type." SET `points` = `points` - 1 WHERE ".$id." = ".$_GET['id']);
				array_push($downvoters, $_SESSION['userid']);
				$_result = implode(" ", $downvoters);
				$conn->query("UPDATE ".$type." SET `downvoters` = \"".$_result."\" WHERE ".$id." = ".$_GET['id']);
			}
		}
		$result = $conn->query("SELECT `points` FROM ".$type." WHERE ".$id." = ".$_GET['id'])->fetch_all()[0][0];
		echo $result;
	}
	$conn->close();
?>
</body>
</html>
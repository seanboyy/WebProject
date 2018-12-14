<!DOCTYPE html>
<html>
<head></head>
<body>
<?php
$conn=mysqli_connect('localhost', 'root', '', 'card_database');
if($conn->connect_errno){
echo "failed to connect";
}
else{
$result = $conn->query("SELECT `card_id`, `card_image` FROM `custom_cards` ORDER BY `points` DESC, `card_id` ASC")->fetch_all();
for($i = 0; $i < count($result); ++$i){
echo "<span class='cardSpan' id='".$result[$i][0]."' onmouseenter='doEntry(".$result[$i][0].", this)' onmouseleave='doLeave(".$result[$i][0].", this)'><a href='./card-view.php?id=".$result[$i][0]."'><img alt='".$result[$i][0]."' src='".$result[$i][1]."' class='cardFormat'/></a></span>";
}
}
$conn->close();
?>
</body>
</html>
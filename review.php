<?php session_start(); include 'dbconnect.php';
if(isset($_POST['r'])){
$conn->query("INSERT INTO reviews(session_id,reviewer_id,rating,feedback)
VALUES('".$_GET['session']."','".$_SESSION['user_id']."','".$_POST['rating']."','".$_POST['feedback']."')");
echo "Review Submitted";
}
?>
<form method="POST">
<select name="rating"><option>5</option><option>4</option><option>3</option><option>2</option><option>1</option></select>
<textarea name="feedback"></textarea>
<button name="r">Submit</button>
</form>

<?php
session_start();
include 'dbconnect.php';
include 'mail_config.php';

$sender = $_SESSION['user_id'];
$receiver = $_GET['to'];
$skill = $_GET['skill'];

// insert request
$conn->query("
INSERT INTO requests(sender_id, receiver_id, skill_wanted, status)
VALUES('$sender','$receiver','$skill','pending')
");

// get receiver email
$r = $conn->query("SELECT email,name FROM users WHERE id='$receiver'");
$user = $r->fetch_assoc();

$to = $user['email'];

$subject = "New Skill Request";

$message = "
Hello ".$user['name']."<br><br>
You have received a request from <b>".$_SESSION['user_name']."</b><br>
Skill: <b>$skill</b><br><br>
Login to accept request.
";

// send mail
sendMail($to, $subject, $message);

// redirect
header("Location: dashboard.php");
?>
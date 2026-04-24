<?php
session_start();
include 'dbconnect.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$request_id = $_GET['id'];
$uid = $_SESSION['user_id'];

// Get request details
$r = $conn->query("SELECT * FROM requests WHERE request_id='$request_id'");
$data = $r->fetch_assoc();

if(!$data){
    echo "Request not found";
    exit();
}

// Identify the OTHER user
// If you are receiver, other is sender
if($data['receiver_id'] == $uid){
    $other_user = $data['sender_id'];
} else {
    $other_user = $data['receiver_id'];
}

// Update request status
$conn->query("UPDATE requests SET status='accepted' WHERE request_id='$request_id'");

// Redirect to chat
header("Location: chat.php?user=$other_user");
exit();
?>

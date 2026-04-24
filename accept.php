<?php
session_start();
include 'dbconnect.php';

if(isset($_GET['id'])){

    $id = $_GET['id'];

    // update request
    $conn->query("UPDATE requests SET status='accepted' WHERE request_id='$id'");

    // get sender id (student)
    $r = $conn->query("SELECT sender_id FROM requests WHERE request_id='$id'");
    $data = $r->fetch_assoc();

    $student = $data['sender_id'];

    // redirect to chat with student
    header("Location: chat.php?user=".$student);
    exit();
}
?>
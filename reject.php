<?php
session_start();
include 'dbconnect.php';

$id = $_GET['id'];

$conn->query("UPDATE requests SET status='rejected' WHERE request_id='$id'");

header("Location: dashboard.php");
exit();
?>
<?php
$conn = mysqli_connect("localhost", "root", "", "skill_exchange");

if(!$conn){
    die("Connection failed: " . mysqli_connect_error());
}
?>
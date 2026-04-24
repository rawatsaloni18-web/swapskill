<?php
$host = "shuttle.proxy.rlwy.net";
$user = "root";
$pass = "UTGKGqdiKyIgicZWBOoWFoZWbWCKsRTB";
$db   = "railway";
$port = "43025";

$conn = new mysqli($host, $user, $pass, $db, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

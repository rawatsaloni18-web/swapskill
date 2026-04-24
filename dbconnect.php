<?php
$host = "shuttle.proxy.rlwy.net";
$user = "root";
$password = "UTGKGqdiKyIgicZWBOoWFoZWbWCKsRTB";
$database = "railway";
$port = 43025;

$conn = new mysqli($host, $user, $password, $database, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

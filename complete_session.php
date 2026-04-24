<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include 'dbconnect.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$me = $_SESSION['user_id'];
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if($id <= 0){
    die("Invalid request");
}

/* CHECK SESSION OWNER */
$check = $conn->query("
SELECT * FROM sessions 
WHERE id='$id' AND (user1='$me' OR user2='$me')
");

if(!$check || $check->num_rows == 0){
    die("Unauthorized access");
}

/* UPDATE STATUS */
$conn->query("
UPDATE sessions 
SET status='completed' 
WHERE id='$id'
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Session Completed</title>
<script src="https://cdn.tailwindcss.com"></script>

<style>
body{
    background:#0c0c0c;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
    font-family: Arial;
}

.popup{
    background:#111827;
    padding:30px 40px;
    border-radius:20px;
    text-align:center;
    box-shadow:0 10px 40px rgba(0,0,0,0.6);
}

.btn{
    margin-top:20px;
    padding:10px 25px;
    border-radius:10px;
    background:#22c55e;
    color:white;
    cursor:pointer;
}
</style>
</head>

<body>

<div class="popup">
    <div style="font-size:40px;">✅</div>
    <h2 class="text-xl font-bold text-white">Session Completed</h2>
    <p class="text-gray-400 mt-2">Great job! 🎉</p>

    <button class="btn" onclick="goHome()">Go to Dashboard</button>
</div>

<script>
function goHome(){
    window.location='dashboard.php';
}

setTimeout(()=>{
    window.location='dashboard.php';
},3000);
</script>

</body>
</html>
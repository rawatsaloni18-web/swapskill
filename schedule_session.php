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
$other = isset($_GET['user']) ? intval($_GET['user']) : 0;

/* SAVE SESSION */
if(isset($_POST['save']) && $other > 0){

    $date = $_POST['date'];
    $time = $_POST['time'];
    $link = $conn->real_escape_string($_POST['link']);

    $conn->query("
    INSERT INTO sessions(user1, user2, meeting_link, session_date, session_time, status)
    VALUES('$me','$other','$link','$date','$time','scheduled')
    ");

    echo "<script>
    alert('Session Scheduled Successfully 🎉');
    window.location='chat.php?user=$other';
    </script>";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Schedule Session</title>

<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/lucide@0.263.0/dist/umd/lucide.min.js"></script>

<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
body{
    font-family:'Outfit',sans-serif;
    background:linear-gradient(135deg,#f8f9fa 0%,#f0f1f5 100%);
}

/* NAV BUTTONS */
.nav-buttons{
    position:absolute;
    top:20px;
    left:20px;
    display:flex;
    gap:10px;
}

.nav-btn{
    display:flex;
    align-items:center;
    gap:6px;
    padding:8px 14px;
    border-radius:10px;
    background:white;
    box-shadow:0 4px 10px rgba(0,0,0,0.1);
    text-decoration:none;
    font-size:14px;
    color:#333;
    transition:0.3s;
}

.nav-btn:hover{
    background:#ff6b6b;
    color:white;
}

/* CARD */
.card{
    background:white;
    border-radius:20px;
    padding:40px 30px;
    width:100%;
    max-width:420px;
    margin:auto;
    margin-top:100px;
    box-shadow:0 8px 32px rgba(0,0,0,0.08);
}

/* HEADER */
.header{
    display:flex;
    align-items:center;
    gap:12px;
    margin-bottom:25px;
}

.icon{
    width:50px;
    height:50px;
    border-radius:12px;
    background:linear-gradient(135deg,#ff6b6b,#ff8787);
    display:flex;
    align-items:center;
    justify-content:center;
    color:white;
}

/* INPUT */
input{
    width:100%;
    padding:12px;
    border-radius:12px;
    border:2px solid #e8e9eb;
    background:#f8f9fa;
    margin-top:8px;
    margin-bottom:15px;
    outline:none;
    transition:0.3s;
}

input:focus{
    border-color:#ff6b6b;
    background:white;
}

/* BUTTON */
button{
    width:100%;
    padding:14px;
    border-radius:12px;
    background:linear-gradient(135deg,#ff6b6b,#ff5252);
    color:white;
    font-weight:600;
    margin-top:10px;
    transition:0.3s;
}

button:hover{
    transform:translateY(-2px);
    box-shadow:0 8px 20px rgba(255,107,107,0.3);
}
</style>
</head>

<body>

<!-- HOME + BACK -->
<div class="nav-buttons">
<a href="index.php" class="nav-btn">
<i data-lucide="home"></i> Home
</a>

<a href="javascript:history.back()" class="nav-btn">
<i data-lucide="arrow-left"></i> Back
</a>
</div>

<div class="card">

<div class="header">
<div class="icon">
<i data-lucide="clock"></i>
</div>
<div>
<h2 class="text-xl font-bold">Schedule Session</h2>
<p class="text-sm text-gray-500">Set up your meeting</p>
</div>
</div>

<form method="POST">

<label class="text-sm font-semibold">Date</label>
<input type="date" name="date" required>

<label class="text-sm font-semibold">Time</label>
<input type="time" name="time" required>

<label class="text-sm font-semibold">Google Meet Link</label>
<input type="text" name="link" placeholder="https://meet.google.com/..." required>

<button name="save">
<i data-lucide="check-circle"></i> Schedule Now
</button>

</form>

</div>

<script>
lucide.createIcons();
</script>

</body>
</html>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include 'dbconnect.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if($id <= 0){
    die("Invalid ID");
}

/* ✅ FIXED QUERY */
$data = $conn->query("
SELECT s.*, u1.name AS teacher_name, u2.name AS student_name
FROM sessions s
JOIN users u1 ON u1.id = s.user1
JOIN users u2 ON u2.id = s.user2
WHERE s.id='$id'
")->fetch_assoc();

if(!$data){
    die("No data found");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Certificate</title>

<script src="https://cdn.tailwindcss.com"></script>

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Outfit:wght@400;600&display=swap" rel="stylesheet">

<style>
body{
    background:#0f172a;
    display:flex;
    justify-content:center;
    align-items:center;
    min-height:100vh;
}

.certificate{
    width:900px;
    padding:50px;
    background:white;
    border-radius:20px;
    position:relative;
    box-shadow:0 20px 60px rgba(0,0,0,0.6);
}

.certificate::before{
    content:"";
    position:absolute;
    inset:-5px;
    border-radius:20px;
    background:linear-gradient(135deg,#facc15,#f97316,#ec4899);
    z-index:-1;
}

.title{
    font-family:'Playfair Display', serif;
    font-size:36px;
    font-weight:bold;
}

.name{
    font-size:28px;
    font-weight:600;
    color:#1e293b;
}

.footer{
    display:flex;
    justify-content:space-between;
    margin-top:50px;
}

.seal{
    width:80px;
    height:80px;
    border-radius:50%;
    border:4px solid gold;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:bold;
}

@media print{
    body{background:white;}
    button{display:none;}
}
</style>
</head>

<body>

<div class="certificate text-center">

<h1 class="title">Certificate of Completion</h1>

<p class="mt-6 text-gray-500">This is proudly presented to</p>

<h2 class="name mt-2">
<?php echo $data['student_name']; ?>
</h2>

<p class="mt-4 text-gray-600">
for successfully completing a skill session in
</p>

<h3 class="text-2xl font-semibold mt-2 text-indigo-600">
<?php echo $data['skill']; ?>
</h3>

<p class="mt-4 text-gray-500">
on <?php echo $data['session_date']; ?>
</p>

<div class="footer">

<div>
<p class="font-semibold">Instructor</p>
<p class="text-gray-500"><?php echo $data['teacher_name']; ?></p>
</div>

<div class="seal">✔</div>

<div>
<p class="font-semibold">SwapSkill</p>
<p class="text-gray-500">Authorized</p>
</div>

</div>

<br>

<button onclick="window.print()" 
class="bg-indigo-600 text-white px-6 py-3 rounded-lg mt-6">
Download Certificate
</button>

</div>

</body>
</html>
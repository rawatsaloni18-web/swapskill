<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include 'dbconnect.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$my_id = $_SESSION['user_id'];

/* INCOMING */
$incoming = $conn->query("
SELECT requests.request_id, users.name AS sender_name, requests.skill_wanted
FROM requests
JOIN users ON users.id = requests.sender_id
WHERE requests.receiver_id='$my_id' AND requests.status='pending'
");
$incoming_count = $incoming ? $incoming->num_rows : 0;

/* ACCEPTED */
$accepted = $conn->query("
SELECT * FROM requests 
WHERE (sender_id='$my_id' OR receiver_id='$my_id') 
AND status='accepted'
");
$accepted_count = $accepted ? $accepted->num_rows : 0;

/* ✅ SESSIONS (NEW - ONLY ADDED) */
$sessions = $conn->query("
SELECT * FROM sessions 
WHERE user1='$my_id' OR user2='$my_id'
");

$session_count = $sessions ? $sessions->num_rows : 0;

?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard</title>
<script src="https://cdn.tailwindcss.com"></script>

<style>
* { margin:0; padding:0; box-sizing:border-box; }

body {
  font-family: 'Geist Mono', sans-serif;
  background: linear-gradient(135deg,#0f172a,#1e293b,#0f172a);
  color:#f1f5f9;
}

/* NAVBAR */
.navbar {
  background: rgba(15, 23, 42, 0.7);
  backdrop-filter: blur(10px);
  border-bottom: 1px solid rgba(148, 163, 184, 0.2);
  padding: 20px 32px;
  display: flex;
  justify-content: space-between;
}

.menu { display:flex; gap:32px; }
.menu a { color:#94a3b8; text-decoration:none; }

/* CARDS */
.card{
  background: rgba(30,41,59,0.6);
  backdrop-filter: blur(10px);
  border:1px solid rgba(255,255,255,0.1);
  border-radius:16px;
  padding:25px;
  transition:0.3s;
}
.card:hover{ transform:translateY(-6px); }

/* GRID */
.stats{
  display:grid;
  grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
  gap:20px;
}

.quick{
  display:grid;
  grid-template-columns:repeat(auto-fit,minmax(200px,1fr));
  gap:15px;
}

.quick-btn{
  padding:15px;
  text-align:center;
  border-radius:12px;
  background: linear-gradient(135deg,#22c55e,#3b82f6);
  color:white;
  text-decoration:none;
}

/* REQUEST */
.request-box{
  display:flex;
  justify-content:space-between;
  margin-bottom:15px;
}

.btn{ padding:8px 14px; border-radius:6px; }
.accept{ background:#22c55e; }
.reject{ background:#ef4444; }
</style>
</head>

<body>

<!-- NAVBAR -->
<div class="navbar">
<h2 class="text-green-400 font-bold text-xl">⇄ SwapSkill</h2>

<div class="menu">
<a href="dashboard.php">Dashboard</a>
<a href="user_profile.php">Profile</a>
<a href="search.php">Search</a>
<a href="index.php">Logout</a>
</div>
</div>

<div style="padding:40px;">

<h2 style="font-size:30px; margin-bottom:30px;">
Welcome, <?php echo $_SESSION['user_name']; ?> 👋
</h2>

<!-- STATS -->
<div class="stats">

<div class="card text-center">
<h3 class="text-4xl text-green-400"><?php echo $incoming_count; ?></h3>
<p>Incoming Requests</p>
</div>

<div class="card text-center">
<h3 class="text-4xl text-blue-400"><?php echo $accepted_count; ?></h3>
<p>Accepted Requests</p>
</div>

<div class="card text-center">
<h3 class="text-4xl text-purple-400"><?php echo $session_count; ?></h3>
<p>Skill Sessions</p>
</div>

</div>

<br><br>

<!-- QUICK -->
<div class="quick">
<a href="profile.php" class="quick-btn">➕ Add Skills</a>
<a href="search.php" class="quick-btn">🔍 Search Skills</a>
<a href="chat.php" class="quick-btn">💬 Chat</a>
</div>

<br><br>

<!-- REQUESTS -->
<h3>Incoming Requests</h3>

<?php
if($incoming_count > 0){
while($row = $incoming->fetch_assoc()){
?>

<div class="card request-box">

<p>
<b><?php echo $row['sender_name']; ?></b>
wants to learn
<b><?php echo $row['skill_wanted']; ?></b>
</p>

<div>
<a href="accept.php?id=<?php echo $row['request_id']; ?>" class="btn accept">Accept</a>
<a href="reject.php?id=<?php echo $row['request_id']; ?>" class="btn reject">Reject</a>
</div>

</div>

<?php }} else { echo "No requests"; } ?>

<!-- ✅ SESSIONS SECTION -->
<h3 style="margin-top:30px;">📅 Sessions</h3>

<?php
if($session_count > 0){
while($row = $sessions->fetch_assoc()){
?>

<div class="card" style="margin-top:10px;">

<p>
📅 <?php echo $row['session_date']; ?> 
⏰ <?php echo $row['session_time']; ?>
</p>

<a href="<?php echo $row['meeting_link']; ?>" target="_blank" style="color:#22c55e;">
🔗 Join Session
</a>

<p>Status: <?php echo $row['status']; ?></p>

<!-- OPTIONAL COMPLETE -->
<a href="complete_session.php?id=<?php echo $row['id']; ?>" 
style="color:orange;">Mark Completed</a>

<a href="certificate.php?id=<?php echo $row['id']; ?>" 
style="color:gold;">
🎓 View Certificate
</a>
</div>

<?php
}
}else{
echo "<p>No sessions</p>";
}
?>

</div>

</body>
</html>
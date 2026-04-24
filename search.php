<?php
session_start();
include 'dbconnect.php';

$me = $_SESSION['user_id'];

$search = isset($_GET['search']) ? $_GET['search'] : '';

$query = "
SELECT users.id, users.name, skills.skill_name
FROM users
JOIN user_skills ON user_skills.user_id = users.id
JOIN skills ON skills.skill_id = user_skills.skill_id
WHERE user_skills.type='teach'
AND users.id != '$me'
";

if($search != ''){
    $query .= " AND skills.skill_name LIKE '%$search%'";
}

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Search Skills</title>

<link href="https://fonts.googleapis.com/css2?family=Geist+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
body {
  font-family: 'Geist Mono', sans-serif;
  background: linear-gradient(135deg, #fdf8f3, #f5e6d3);
  color:#2d1810;
}

/* NAVBAR */
.navbar {
  background: rgba(255,255,255,0.7);
  backdrop-filter: blur(10px);
  padding:20px 32px;
  display:flex;
  justify-content:space-between;
}

.logo {
  font-size:22px;
  font-weight:700;
  color:#ea580c;
}

.menu a {
  margin-left:20px;
  text-decoration:none;
  color:#92400e;
}

/* HEADER */
.header {
  text-align:center;
  padding:40px;
}

.header h1 {
  font-size:40px;
}

/* SEARCH BOX */
.search-box {
  background:white;
  padding:25px;
  border-radius:20px;
  max-width:600px;
  margin:auto;
}

.search-box form {
  display:flex;
  gap:10px;
}

.search-box input {
  flex:1;
  padding:12px;
}

.search-box button {
  background:#ed382b;
  color:white;
  border:none;
  padding:12px 20px;
}

/* RESULTS */
.grid {
  display:grid;
  grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
  gap:20px;
  margin:40px;
}

.card {
  background:white;
  padding:20px;
  border-radius:16px;
}

.btn {
  display:block;
  margin-top:15px;
  background:#ea580c;
  color:white;
  padding:10px;
  text-align:center;
  text-decoration:none;
}
</style>

</head>
<body>

<!-- NAVBAR -->
<div class="navbar">
  <div class="logo">⇄ SwapSkill</div>
  <div class="menu">
    <a href="dashboard.php">Dashboard</a>
    <a href="profile.php">Manage Skills</a>
    <a href="search.php">Search</a>
    <a href="logout.php">Logout</a>
  </div>
</div>

<!-- HEADER -->
<div class="header">
  <h1>Search Skills</h1>
  <p>Find people who can teach you</p>
</div>

<!-- SEARCH -->
<div class="search-box">
<form method="POST">
<input type="text" name="skill" placeholder="Search for a skill..." required>
<button name="search">Search</button>
</form>
</div>

<!-- RESULTS -->
<div class="grid">

<?php
if(isset($_POST['search'])){

$skill = $_POST['skill'];

/* FIXED QUERY */
$r = $conn->query("
SELECT users.id, users.name 
FROM users 
JOIN user_skills ON users.id = user_skills.user_id
JOIN skills ON skills.skill_id = user_skills.skill_id
WHERE skills.skill_name LIKE '%$skill%'
AND user_skills.type = 'teach'
");

if($r->num_rows > 0){
while($row = $r->fetch_assoc()){
?>

<div class="card">
<h3><?php echo $row['name']; ?></h3>
<p>Teaches: <?php echo $skill; ?></p>

<a class="btn" href="request.php?to=<?php echo $row['id']; ?>&skill=<?php echo $skill; ?>">
Send Request
</a>
</div>

<?php
}
}else{
echo "<p style='text-align:center;'>No users found</p>";
}
}
?>

</div>

</body>
</html>
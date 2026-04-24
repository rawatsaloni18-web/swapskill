<?php
session_start();
include 'dbconnect.php';

$skill = $_GET['skill'];
$level = $_GET['level'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Teachers</title>

<!-- Tailwind -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- Icons -->
<script src="https://cdn.jsdelivr.net/npm/lucide@0.263.0/dist/umd/lucide.min.js"></script>

<!-- Font -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

<style>
body {
    font-family: 'Poppins', sans-serif;
}

/* CARD */
.teacher-card {
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.1);
    transition: 0.4s;
}
.teacher-card:hover {
    transform: scale(1.05);
    box-shadow: 0 20px 40px rgba(168,85,247,0.3);
}

/* BUTTON */
.send-btn {
    background: linear-gradient(135deg,#ec4899,#f97316);
    transition: 0.3s;
}
.send-btn:hover {
    transform: translateY(-2px);
}
</style>

</head>

<body class="min-h-screen text-white px-6 py-12"
style="background: linear-gradient(135deg,#0a0a1a,#1a1a3e);">

<div class="max-w-5xl mx-auto text-center">

<h1 class="text-4xl font-bold mb-3">
Recommended Teachers
</h1>

<p class="text-gray-300 mb-10">
Skill: <?php echo htmlspecialchars($skill); ?> | Level: <?php echo htmlspecialchars($level); ?>
</p>

<div class="grid md:grid-cols-3 gap-6">

<?php
$result = $conn->query("
SELECT users.id, users.name 
FROM users
JOIN user_skills ON users.id = user_skills.user_id
JOIN skills ON skills.skill_id = user_skills.skill_id
WHERE skills.skill_name LIKE '%$skill%'
AND user_skills.type='teach'
LIMIT 3
");

if($result->num_rows > 0){
while($row = $result->fetch_assoc()){
?>

<div class="teacher-card p-6 rounded-2xl text-center">

<!-- AVATAR -->
<div class="w-20 h-20 mx-auto mb-4 rounded-xl flex items-center justify-center text-2xl font-bold"
style="background:linear-gradient(135deg,#a855f7,#6366f1);">
<?php echo strtoupper(substr($row['name'],0,2)); ?>
</div>

<h3 class="text-lg font-bold mb-2">
<?php echo $row['name']; ?>
</h3>

<p class="text-gray-400 text-sm mb-4">
Teaches <?php echo $skill; ?>
</p>

<!-- BUTTON -->
<a href="request.php?to=<?php echo $row['id']; ?>&skill=<?php echo $skill; ?>"
class="send-btn px-4 py-2 rounded-lg inline-flex items-center gap-2 text-sm font-semibold">

<i data-lucide="send"></i>
Send Request

</a>

</div>

<?php
}
}else{
echo "<p class='text-gray-400'>No teachers found</p>";
}
?>

</div>

</div>

<script>
lucide.createIcons();
</script>

</body>
</html>
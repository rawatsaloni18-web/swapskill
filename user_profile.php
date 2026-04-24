<?php
session_start();
include 'dbconnect.php';

$uid = $_SESSION['user_id'];

$user = $conn->query("SELECT * FROM users WHERE id='$uid'")->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
<title>My Profile</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-orange-100 via-pink-100 to-yellow-100 font-sans">

<!-- TOP BAR -->
<div class="flex justify-between items-center p-4 bg-white shadow">
    <h2 class="font-bold text-orange-500 text-lg">⇄ SwapSkill</h2>
    
    <div class="flex gap-3">

<a href="index.php"
class="px-4 py-2 rounded-full bg-gradient-to-r from-blue-500 to-indigo-500 
text-white text-sm font-semibold shadow-md hover:scale-105 transition flex items-center gap-2">

🏠 Home
</a>

<a href="javascript:history.back()"
class="px-4 py-2 rounded-full bg-white text-gray-700 border border-gray-300 
text-sm font-semibold shadow-sm hover:bg-gray-100 transition flex items-center gap-2">

⬅ Back
</a>

</div>
</div>

<!-- PROFILE CARD -->
<div class="flex justify-center items-center mt-10">

<div class="w-80 bg-white rounded-2xl shadow-xl p-6 text-center">

<!-- PROFILE PIC -->
<?php if(!empty($user['profile_pic'])){ ?>
<img src="uploads/<?php echo $user['profile_pic']; ?>" 
class="w-28 h-28 mx-auto rounded-full border-4 border-orange-400 shadow">
<?php } ?>

<!-- NAME -->
<h2 class="text-2xl font-bold mt-4">
<?php echo htmlspecialchars($user['name']); ?>
</h2>

<!-- EMAIL -->
<p class="text-gray-500">
<?php echo $user['email']; ?>
</p>

<!-- EDUCATION -->
<p class="mt-2 text-gray-700">
<?php echo htmlspecialchars($user['education']); ?>
</p>

<!-- EDIT BUTTON -->
<a href="edit_profile.php" 
class="inline-block mt-4 bg-orange-500 hover:bg-orange-600 text-white px-5 py-2 rounded-lg shadow">
Edit Profile
</a>

<!-- SKILLS -->
<h3 class="mt-6 font-semibold text-lg">Skills</h3>

<?php
if(!empty($user['skills'])){

$skills = explode(",", $user['skills']);

foreach($skills as $s){

$parts = explode(":", $s);
$name = trim($parts[0]);
$level = isset($parts[1]) ? $parts[1] : 50;
?>

<div class="mt-4 text-left">

<p class="font-medium"><?php echo $name; ?> - <?php echo $level; ?>%</p>

<div class="w-full bg-gray-200 h-2 rounded-full mt-1">
<div class="bg-orange-500 h-2 rounded-full" style="width:<?php echo $level; ?>%"></div>
</div>

</div>

<?php
}
}else{
echo "<p class='text-gray-500 mt-3'>No skills added</p>";
}
?>

</div>

</div>

</body>
</html>
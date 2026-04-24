<?php
$skill = $_GET['skill'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Select Level</title>

<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/lucide@0.263.0/dist/umd/lucide.min.js"></script>

<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">

<style>
body {
    font-family: 'DM Sans', sans-serif;
}

.level-card {
    transition: all 0.3s ease;
}
.level-card:hover {
    transform: translateY(-6px);
}

@keyframes fadeUp {
    from {opacity:0; transform:translateY(20px);}
    to {opacity:1; transform:translateY(0);}
}
.animate-in {
    animation: fadeUp 0.5s ease forwards;
    opacity:0;
}
</style>

</head>

<body class="min-h-screen flex flex-col"
style="background: linear-gradient(135deg,#667eea,#764ba2);">

<!-- ✅ TOP NAV -->
<div class="flex justify-between items-center px-6 py-4 bg-white/10 backdrop-blur border-b border-white/20">

<h2 class="text-white font-bold text-lg">⇄ SwapSkill</h2>

<div class="flex gap-3">

<a href="index.php"
class="flex items-center gap-2 px-4 py-2 rounded-full bg-white text-purple-700 
text-sm font-semibold shadow hover:scale-105 transition">

<i data-lucide="home" class="w-4"></i>
Home
</a>

<a href="javascript:history.back()"
class="flex items-center gap-2 px-4 py-2 rounded-full bg-white/20 border border-white/30 
text-white text-sm font-semibold hover:bg-white/30 transition">

<i data-lucide="arrow-left" class="w-4"></i>
Back
</a>

</div>
</div>

<!-- MAIN -->
<div class="flex-1 flex items-center justify-center px-6">

<div class="text-center w-full max-w-5xl">

<h1 class="text-4xl font-bold text-white mb-2 animate-in">
Select Level for <?php echo htmlspecialchars($skill); ?>
</h1>

<p class="text-white/80 mb-12 animate-in">
Choose your difficulty that matches your experience
</p>

<div class="flex flex-col md:flex-row gap-6">

<!-- BASIC -->
<a href="teachers.php?skill=<?php echo $skill; ?>&level=basic"
class="level-card flex-1 bg-white rounded-3xl p-8 text-center animate-in">

<div class="w-16 h-16 mx-auto mb-5 flex items-center justify-center rounded-full bg-green-500 text-white">
<i data-lucide="book-open"></i>
</div>

<h3 class="text-xl font-bold text-gray-800 mb-2">Beginner</h3>
<p class="text-gray-500 text-sm mb-6">Start with the fundamentals and build confidence from scratch.</p>

<button class="w-full py-3 rounded-xl text-white font-semibold bg-green-500 hover:scale-105 transition">
Get Started
</button>

</a>

<!-- NORMAL -->
<a href="teachers.php?skill=<?php echo $skill; ?>&level=normal"
class="level-card flex-1 bg-white rounded-3xl p-8 text-center animate-in scale-105">

<div class="w-16 h-16 mx-auto mb-5 flex items-center justify-center rounded-full bg-yellow-500 text-white">
<i data-lucide="zap"></i>
</div>

<h3 class="text-xl font-bold text-gray-800 mb-2">Intermediate</h3>
<p class="text-gray-500 text-sm mb-6">Deepen your skills with advanced concepts and challenges.</p>

<button class="w-full py-3 rounded-xl text-white font-semibold bg-yellow-500 hover:scale-105 transition">
Continue
</button>

</a>

<!-- ADVANCED -->
<a href="teachers.php?skill=<?php echo $skill; ?>&level=advanced"
class="level-card flex-1 bg-white rounded-3xl p-8 text-center animate-in">

<div class="w-16 h-16 mx-auto mb-5 flex items-center justify-center rounded-full bg-red-500 text-white">
<i data-lucide="flame"></i>
</div>

<h3 class="text-xl font-bold text-gray-800 mb-2">Expert</h3>
<p class="text-gray-500 text-sm mb-6">Master complex topics and push your limits to the edge.</p>

<button class="w-full py-3 rounded-xl text-white font-semibold bg-red-500 hover:scale-105 transition">
Challenge
</button>

</a>

</div>

</div>

</div>

<script>
lucide.createIcons();
</script>

</body>
</html>
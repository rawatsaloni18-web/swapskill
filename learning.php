<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Learning Skills</title>

<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/lucide@0.263.0/dist/umd/lucide.min.js"></script>

<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&display=swap" rel="stylesheet">

<style>
body { font-family: 'Outfit', sans-serif; }

.skill-card { transition: all 0.4s ease; }
.skill-card:hover { transform: translateY(-8px) scale(1.02); }

.icon-ring { transition: 0.4s; }
.skill-card:hover .icon-ring { transform: scale(1.1) rotate(5deg); }

@keyframes fadeUp {
    from {opacity:0; transform:translateY(30px);}
    to {opacity:1; transform:translateY(0);}
}
.animate-in {
    animation: fadeUp 0.6s ease forwards;
    opacity:0;
}
.delay-1 { animation-delay:0.1s; }
.delay-2 { animation-delay:0.2s; }
.delay-3 { animation-delay:0.3s; }
.delay-4 { animation-delay:0.4s; }
.delay-5 { animation-delay:0.5s; }
</style>
</head>

<body class="h-full text-white">

<!-- ✅ TOP NAV -->
<div class="flex justify-between items-center px-6 py-3 bg-black/10 backdrop-blur border-b border-white/10">

<h2 class="text-lg font-bold text-black">⇄ SwapSkill</h2>

<div class="flex gap-3">

<a href="index.php"
class="flex items-center gap-2 px-4 py-2 rounded-full bg-gradient-to-r from-purple-500 to-pink-500 
text-white text-sm font-semibold hover:scale-105 transition">

<i data-lucide="home" class="w-4"></i>
Home
</a>

<a href="javascript:history.back()"
class="flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 border border-white/20 
text-black text-sm font-semibold hover:bg-white/50 transition">

<i data-lucide="arrow-left" class="w-4"></i>
Back
</a>

</div>
</div>

<!-- MAIN -->
<main class="min-h-screen flex flex-col items-center justify-center px-6 py-16"
style="background: radial-gradient(circle at top,#1a1a2e,#0c0c0c);">

<!-- TITLE -->
<div class="animate-in mb-2">
<span class="px-4 py-1 rounded-full text-xs font-semibold uppercase"
style="background: rgba(255,200,60,0.1); color:#ffc83c;">
Start Learning
</span>
</div>

<h1 class="animate-in delay-1 text-4xl font-bold mt-4 mb-3">
Select a Skill
</h1>

<p class="animate-in delay-1 text-gray-400 mb-12">
Choose what you'd like to learn today
</p>

<!-- CARDS -->
<div class="grid sm:grid-cols-3 gap-6 w-full max-w-5xl">

<!-- (ALL YOUR EXISTING CARDS SAME) -->
<!-- KEEP EVERYTHING SAME BELOW -->

<!-- COMMUNICATION -->
<a href="level.php?skill=communication"
class="skill-card animate-in delay-1 block p-8 rounded-2xl text-center"
style="background:#161621; border:1px solid #2a2a3a;">
<div class="icon-ring w-20 h-20 mx-auto mb-5 flex items-center justify-center text-4xl rounded-xl"
style="background:linear-gradient(135deg,#3b82f6,#1e3a8a);">🗣️</div>
<h3 class="text-lg font-bold">Communication</h3>
<p class="text-gray-400 text-sm">Confidence & speaking</p>
<div class="mt-3 text-xs text-yellow-400 flex justify-center gap-1">
Begin <i data-lucide="arrow-right" class="w-4"></i>
</div>
</a>

<!-- DIGITAL -->
<a href="level.php?skill=digital"
class="skill-card animate-in delay-2 block p-8 rounded-2xl text-center"
style="background:#161621; border:1px solid #2a2a3a;">
<div class="icon-ring w-20 h-20 mx-auto mb-5 flex items-center justify-center text-4xl rounded-xl"
style="background:linear-gradient(135deg,#06b6d4,#0e7490);">💻</div>
<h3 class="text-lg font-bold">Digital Skills</h3>
<p class="text-gray-400 text-sm">Computer & internet</p>
<div class="mt-3 text-xs text-yellow-400 flex justify-center gap-1">
Begin <i data-lucide="arrow-right" class="w-4"></i>
</div>
</a>

<!-- LANGUAGE -->
<a href="level.php?skill=language"
class="skill-card animate-in delay-3 block p-8 rounded-2xl text-center"
style="background:#161621; border:1px solid #2a2a3a;">
<div class="icon-ring w-20 h-20 mx-auto mb-5 flex items-center justify-center text-4xl rounded-xl"
style="background:linear-gradient(135deg,#1e3a5f,#0d1b2a);">🌐</div>
<h3 class="text-lg font-bold">Language</h3>
<p class="text-gray-400 text-sm">Learn new languages</p>
<div class="mt-3 text-xs text-yellow-400 flex justify-center gap-1">
Begin <i data-lucide="arrow-right" class="w-4"></i>
</div>
</a>

<!-- CREATIVE -->
<a href="level.php?skill=creative"
class="skill-card animate-in delay-4 block p-8 rounded-2xl text-center"
style="background:#161621; border:1px solid #2a2a3a;">
<div class="icon-ring w-20 h-20 mx-auto mb-5 flex items-center justify-center text-4xl rounded-xl"
style="background:linear-gradient(135deg,#ec4899,#7c2d12);">🎨</div>
<h3 class="text-lg font-bold">Creative Skills</h3>
<p class="text-gray-400 text-sm">Art & creativity</p>
<div class="mt-3 text-xs text-yellow-400 flex justify-center gap-1">
Begin <i data-lucide="arrow-right" class="w-4"></i>
</div>
</a>

<!-- MUSIC -->
<a href="level.php?skill=music"
class="skill-card animate-in delay-5 block p-8 rounded-2xl text-center"
style="background:#161621; border:1px solid #2a2a3a;">
<div class="icon-ring w-20 h-20 mx-auto mb-5 flex items-center justify-center text-4xl rounded-xl"
style="background:linear-gradient(135deg,#22c55e,#14532d);">🎵</div>
<h3 class="text-lg font-bold">Music</h3>
<p class="text-gray-400 text-sm">Rhythm & performance</p>
<div class="mt-3 text-xs text-yellow-400 flex justify-center gap-1">
Begin <i data-lucide="arrow-right" class="w-4"></i>
</div>
</a>

</div>

</main>

<script>
lucide.createIcons();
</script>

</body>
</html>
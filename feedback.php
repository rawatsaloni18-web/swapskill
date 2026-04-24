<?php
session_start();
include 'dbconnect.php';

if(isset($_POST['name'])){

$name = $_POST['name'];
$email = $_POST['email'];
$rating = $_POST['rating'];
$category = $_POST['category'];
$message = $_POST['message'];

$conn->query("INSERT INTO feedback(name,email,rating,category,message)
VALUES('$name','$email','$rating','$category','$message')");

echo "
<div id='successBox' style='
position:fixed;
top:50%;
left:50%;
transform:translate(-50%,-50%);
background:#ffe0e0;
padding:30px 40px;
border-radius:20px;
box-shadow:0 10px 40px rgba(0,0,0,0.2);
text-align:center;
z-index:9999;
animation:pop 0.5s ease;
'>

<h2 style='font-size:22px;color:#ea580c;margin-bottom:10px;'>🎉 Thank You!</h2>

<p style='color:#334155;font-size:14px;'>
Your feedback has been submitted successfully 😊
</p>

</div>

<style>
@keyframes pop {
from {opacity:0; transform:translate(-50%,-60%) scale(0.8);}
to {opacity:1; transform:translate(-50%,-50%) scale(1);}
}
</style>

<script>
setTimeout(function(){
window.location.href='index.php';
}, 2000);
</script>
";
exit();

}
?>

<!doctype html>
<html lang="en" class="h-full">
<head>
<meta charset="UTF-8">
<title>Feedback</title>

<script src="https://cdn.tailwindcss.com/3.4.17"></script>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
.animated-bg {
  background: linear-gradient(270deg,#ff9a9e,#fad0c4,#fbc2eb,#a18cd1,#84fab0,#8fd3f4);
  background-size: 400% 400%;
  animation: gradientMove 12s ease infinite;
  min-height: 100vh;
}
@keyframes gradientMove {
  0%{background-position:0% 50%;}
  50%{background-position:100% 50%;}
  100%{background-position:0% 50%;}
}
* { font-family: 'Poppins', sans-serif; }
.emoji-rating { font-size:48px; cursor:pointer; }
.category-option { cursor:pointer; }

/* INPUT + TEXTAREA */
input, textarea {
  width: 100%;
  padding: 14px 16px;
  border-radius: 14px;
  border: 2px solid #e2e8f0;
  background: linear-gradient(135deg, #ffffff, #f8fafc);
  font-size: 14px;
  transition: all 0.3s ease;
  outline: none;
}

/* PLACEHOLDER */
input::placeholder,
textarea::placeholder {
  color: #94a3b8;
}

/* FOCUS EFFECT */
input:focus, textarea:focus {
  border-color: #ea580c;
  box-shadow: 0 0 0 3px rgba(234, 88, 12, 0.2);
  background: #ffffff;
}

/* HOVER */
input:hover, textarea:hover {
  border-color: #cbd5f5;
}

.emoji-rating {
  transition: all 0.3s ease;
  cursor: pointer;
}

.emoji-rating:hover {
  transform: scale(1.3) rotate(10deg);
}

.emoji-rating.active {
  transform: scale(1.4);
  filter: drop-shadow(0 5px 10px rgba(0,0,0,0.3));
}

.category-option {
  padding: 12px;
  border-radius: 12px;
  font-weight: 600;
  transition: all 0.3s ease;
}

.category-option:hover {
  transform: translateY(-3px);
  box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.category-option.active {
  border: 2px solid #000;
  transform: scale(1.05);
}

label {
  font-size: 13px;
  font-weight: 600;
  color: #334155;
}

</style>
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
</head>

<body class="h-full animated-bg">

<div class="min-h-full flex flex-col items-center justify-center px-4 py-16">

<div class="w-full max-w-xl">

<div class="text-center mb-12">
<h1 class="text-5xl font-bold" style="color:#31085e;">
We'd Love Your Feedback
</h1>

<p style="color:#19124d;">
Help us create something amazing
</p></div>

<form method="POST" class="rounded-3xl p-10 space-y-8 bg-white">

<!-- hidden -->
<input type="hidden" name="rating" id="rating">
<input type="hidden" name="category" id="category">

<div>
<label>Your Name</label>
<input type="text" name="name" id="name" required class="w-full p-3 border rounded">
</div>

<div>
<label>Email</label>
<input type="email" name="email" id="email" required class="w-full p-3 border rounded">
</div>

<div>
<label class="block text-sm font-semibold mb-3">How would you rate us?</label>

<div class="flex justify-center gap-4 text-4xl">

<button type="button" class="emoji-rating">😟</button>
<button type="button" class="emoji-rating">😐</button>
<button type="button" class="emoji-rating">🙂</button>
<button type="button" class="emoji-rating">😊</button>
<button type="button" class="emoji-rating">🤩</button>

</div>
</div>
<div>
<label class="block text-sm font-semibold mb-3">Category</label>

<div class="grid grid-cols-2 gap-3">

<button type="button" class="category-option bg-yellow-300">General</button>
<button type="button" class="category-option bg-red-400 text-white">Bug</button>
<button type="button" class="category-option bg-blue-400 text-white">Feature</button>
<button type="button" class="category-option bg-purple-400 text-white">Praise</button>

</div>
</div>

<div>
<label>Message</label>
<textarea name="message" id="message" required class="w-full p-3 border rounded"></textarea>
</div>

<button type="submit" class="w-full bg-pink-500 text-white p-3 rounded">
Send Feedback
</button>

</form>

</div>
</div>

<script>
let currentRating = 0;
let selectedCategory = "";

// rating
document.querySelectorAll('.emoji-rating').forEach((btn, index)=>{
btn.addEventListener('click',()=>{

document.querySelectorAll('.emoji-rating').forEach(b=>b.classList.remove('active'));

btn.classList.add('active');
document.getElementById('rating').value = index+1;

});
});

// category
document.querySelectorAll('.category-option').forEach(btn=>{
btn.addEventListener('click',()=>{

document.querySelectorAll('.category-option').forEach(b=>b.classList.remove('active'));

btn.classList.add('active');
document.getElementById('category').value = btn.innerText;

});
});
</script>

</body>
</html>
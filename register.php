<?php
include 'dbconnect.php';

if(isset($_POST['register'])){

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Prepared statement (secure)
    $stmt = $conn->prepare("INSERT INTO users(name,email,password) VALUES(?,?,?)");
    $stmt->bind_param("sss", $name, $email, $password);

    if($stmt->execute()){
        header("Location: login.php");
        exit();
    } else {
        $error = "Registration failed!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register</title>

<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/lucide@0.263.0/dist/umd/lucide.min.js"></script>

<style>
body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #0f172a, #1e293b, #0f172a);
}

.login-card {
    background: rgba(30, 41, 59, 0.7);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 50px;
    max-width: 420px;
    width: 100%;
}

.input-field {
    background: rgba(15, 23, 42, 0.5);
    border: 2px solid rgba(148, 163, 184, 0.2);
    color: #f1f5f9;
    border-radius: 12px;
    padding: 12px;
    width: 100%;
}

.btn-primary {
    width: 100%;
    padding: 12px;
    border-radius: 12px;
    background: linear-gradient(135deg, #ec4899, #8b5cf6);
    color: white;
    font-weight: bold;
}
</style>
</head>

<body class="flex items-center justify-center min-h-screen">

<div class="login-card">

<span class="text-pink-400 text-sm font-bold">⚡ CREATE ACCOUNT</span>

<h1 class="text-2xl text-white font-bold mt-2">Create Account</h1>
<p class="text-gray-400 mb-6">Join us today</p>

<?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

<form method="POST">

<!-- NAME -->
<label class="text-gray-300">Full Name</label>
<input type="text" name="name" placeholder="John Doe" class="input-field mb-4" required>

<!-- EMAIL -->
<label class="text-gray-300">Email Address</label>
<input type="email" name="email" placeholder="you@example.com" class="input-field mb-4" required>

<!-- PASSWORD -->
<label class="text-gray-300">Password</label>
<div class="relative mb-4">
<input type="password" name="password" id="password-field" class="input-field" required>

<button type="button" id="toggle-pw" class="absolute right-3 top-3 text-gray-400">
👁
</button>
</div>

<!-- TERMS -->
<div class="mb-4 text-gray-400 text-sm">
<label>
<input type="checkbox" required> I agree to the Terms and Conditions
</label>
</div>

<!-- SUBMIT -->
<button type="submit" name="register" class="btn-primary">
CREATE ACCOUNT
</button>

</form>

<p class="text-gray-400 mt-4 text-center">
Already have an account?
<a href="login.php" class="text-pink-400">Sign in</a>
</p>

</div>

<script>
// show/hide password
document.getElementById("toggle-pw").onclick = function(){
    let pw = document.getElementById("password-field");
    pw.type = (pw.type === "password") ? "text" : "password";
}
</script>

</body>
</html>
<?php
session_start();
include 'dbconnect.php';

if(isset($_POST['login'])){

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // get user by email
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){

        $user = $result->fetch_assoc();

        // ✅ plain password match
        if($password == $user['password']){

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];   // 🔥 important

            header("Location: dashboard.php");
            exit();

        }else{
            $error = "Wrong Password!";
        }

    }else{
        $error = "User not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>

<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/lucide@0.263.0/dist/umd/lucide.min.js"></script>

<style>
body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #0f172a, #1e293b, #334155);
}

.login-card {
    background: rgba(15, 23, 42, 0.8);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    padding: 40px;
    width: 100%;
    max-width: 420px;
}

.input-field {
    background: rgba(30, 41, 59, 0.6);
    border: 1px solid rgba(148, 163, 184, 0.2);
    color: white;
    border-radius: 10px;
    padding: 12px;
    width: 100%;
}

.btn-primary {
    width: 100%;
    padding: 12px;
    border-radius: 10px;
    background: #10b981;
    color: white;
    font-weight: bold;
}
</style>
</head>

<body class="flex items-center justify-center h-screen">

<div class="login-card">

<span class="text-green-400 text-sm font-bold">⚡ LOGIN PAGE</span>

<h1 class="text-2xl text-white font-bold mt-2">Welcome Back</h1>
<p class="text-gray-400 mb-6">Sign in to your account</p>

<?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

<form method="POST">

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

<div class="flex justify-between text-sm mb-4 text-gray-400">
<label><input type="checkbox"> Remember me</label>
<a href="#" class="text-green-400">Forgot?</a>
</div>

<!-- SUBMIT -->
<button type="submit" name="login" class="btn-primary">
SIGN IN
</button>

</form>

<p class="text-gray-400 mt-4 text-center">
Don't have an account?
<a href="register.php" class="text-green-400">Sign up</a>
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
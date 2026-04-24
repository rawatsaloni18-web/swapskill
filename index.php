<?php
session_start();
?>



<!DOCTYPE html>
<html>
<head>
    <title>SwapSkill</title>

    <!-- NEW FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="css/home-style.css">

    <style>
    /* NAVBAR FONT UPDATE */
    .nav-links a {
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #cbd5f5;
        position: relative;
        transition: 0.3s;
    }

    /* UNDERLINE ANIMATION */
    .nav-links a::after {
        content: "";
        position: absolute;
        width: 0%;
        height: 2px;
        background: #a855f7;
        bottom: -4px;
        left: 0;
        transition: 0.3s;
    }

    .nav-links a:hover::after {
        width: 100%;
    }

    .nav-links a:hover {
        color: white;
    }
    </style>
</head>

<body>

<!-- NAVBAR -->
<div class="navbar">
    <div class="logo">⇄ SwapSkill</div>

    <div class="nav-links">
        <a href="learning.php">Our Recommandations for Skils</a>
        <a href="user_profile.php">Profile</a>
        <a href="login.php">Login</a>
        <a href="feedback.php">Feedback</a>
    </div>
</div>

<!-- HERO SECTION -->
<div class="hero">

    <div class="hero-text">
        <h4>SWAPSKILL IS BUILT</h4>

        <h1>
            ON THE BELIEF THAT EVERYONE  
            HAS SOMETHING VALUABLE TO  
            TEACH AND SOMETHING NEW  
            TO LEARN.
        </h1>

        <p>
            By exchanging skills, we grow together, build confidence,
            and create a community where knowledge is shared, not sold.
        </p>

        <a href="register.php" class="hero-btn">
            SIGN UP →
        </a>
    </div>

    <div class="hero-img">
        <img src="images/skills.png" alt="Skills">
    </div>

</div>

</body>
</html>
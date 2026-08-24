<?php
session_start();

if(isset($_SESSION['user_id'])){

    if($_SESSION['role']=="admin"){
        header("Location: admin/dashboard.php");
    }else{
        header("Location: dashboard.php");
    }

    exit();
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Lost & Found Management System</title>

<link rel="stylesheet" href="assets/css/style.css">

</head>

<body class="home-page">

<header class="home-header">

<div class="logo">
<h2>Lost & Found System</h2>
</div>

<nav>

<a href="login.php">Login</a>

<a href="register.php" class="btn-nav">
Register
</a>

</nav>

</header>

<section class="hero">

<div class="hero-text">

<h1>Find Your Lost Belongings Easily</h1>

<p>

Report lost items, report found items, browse available
items and securely claim your belongings.

</p>

<a href="register.php" class="hero-btn">

Get Started

</a>

</div>

</section>

<section class="features">

<h2>Our Features</h2>

<div class="feature-grid">

<div class="feature-card">

<h3> Report Lost Items</h3>

<p>
Quickly report any lost belongings.
</p>

</div>

<div class="feature-card">

<h3> Report Found Items</h3>

<p>
Help others by reporting found items.
</p>

</div>

<div class="feature-card">

<h3> Browse Items</h3>

<p>
Search through reported lost and found items.
</p>

</div>

<div class="feature-card">

<h3> Secure Claim Process</h3>

<p>
Admin verifies claims before approving ownership.
</p>

</div>

</div>

</section>

<section class="about">

<h2>About This Project</h2>

<p>

The Lost & Found Management System is developed
to help students and staff report, search and recover
lost belongings efficiently within the college.

</p>

</section>

<footer>

<p>

© 2026 Lost & Found Management System

<br>

Developed by Harpal Khadka Chhetri

</p>

</footer>

</body>
</html>
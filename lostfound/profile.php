<?php
include("includes/auth.php");
include("config/db.php");

$id = $_SESSION['user_id'];

$query = mysqli_query($conn,
"SELECT * FROM users WHERE id='$id'");

$user = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html>

<head>

<title>My Profile</title>

<link rel="stylesheet" href="assets/css/style.css">

</head>

<body>

<?php include("includes/sidebar.php"); ?>

<div class="main">

<?php include("includes/header.php"); ?>

<h2>My Profile</h2>

<div class="profile-card">

<div class="profile-row">
<label>Full Name</label>
<p><?php echo htmlspecialchars($user['fullname']); ?></p>
</div>

<div class="profile-row">
<label>Student ID</label>
<p><?php echo htmlspecialchars($user['user_id']); ?></p>
</div>

<div class="profile-row">
<label>Email</label>
<p><?php echo htmlspecialchars($user['email']); ?></p>
</div>

<div class="profile-row">
<label>Role</label>
<p><?php echo ucfirst($user['role']); ?></p>
</div>

<div class="profile-row">
<label>Joined</label>
<p><?php echo $user['created_at']; ?></p>
</div>

<div class="profile-buttons">

<a href="edit_profile.php">
<button>Edit Profile</button>
</a>

<a href="change_password.php">
<button>Change Password</button>
</a>

</div>

</div>

<?php include("includes/footer.php"); ?>
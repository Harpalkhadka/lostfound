<?php
include("includes/auth.php");
include("config/db.php");

$id = $_SESSION['user_id'];
$message = "";
$class = "";

if(isset($_POST['change'])){

    $current = $_POST['current_password'];
    $new = $_POST['new_password'];
    $confirm = $_POST['confirm_password'];

    $result = mysqli_query($conn,"SELECT * FROM users WHERE id='$id'");
    $user = mysqli_fetch_assoc($result);

    if(!password_verify($current,$user['password'])){

        $message = "Current password is incorrect.";
        $class = "msg";

    }
    elseif($new != $confirm){

        $message = "New passwords do not match.";
        $class = "msg";

    }
    else{

        $newPassword = password_hash($new, PASSWORD_DEFAULT);

        mysqli_query($conn,
        "UPDATE users
        SET password='$newPassword'
        WHERE id='$id'");

        $message = "Password changed successfully!";
        $class = "msg success";
    }

}
?>

<!DOCTYPE html>
<html>

<head>

<title>Change Password</title>
<link rel="stylesheet" href="assets/css/style.css">

</head>

<body>

<?php include("includes/sidebar.php"); ?>

<div class="main">

<?php include("includes/header.php"); ?>

<h2>Change Password</h2>

<?php
if($message!=""){
?>
<p class="<?php echo $class; ?>">
<?php echo $message; ?>
</p>
<?php
}
?>

<div class="profile-card">

<form method="POST">

<label>Current Password</label>

<input
type="password"
name="current_password"
required>

<label>New Password</label>

<input
type="password"
name="new_password"
required>

<label>Confirm New Password</label>

<input
type="password"
name="confirm_password"
required>

<button
type="submit"
name="change">

Change Password

</button>

</form>

</div>

<?php include("includes/footer.php"); ?>
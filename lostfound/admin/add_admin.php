<?php
include("auth.php");
include("../config/db.php");

if($_SESSION['role']!="admin"){
    header("Location:../dashboard.php");
    exit();
}

$message="";

if(isset($_POST['add'])){

    $fullname=mysqli_real_escape_string($conn,$_POST['fullname']);
    $teacher_id=mysqli_real_escape_string($conn,$_POST['teacher_id']);
    $email=mysqli_real_escape_string($conn,$_POST['email']);
    $password=password_hash($_POST['password'],PASSWORD_DEFAULT);

    $check=mysqli_query($conn,
    "SELECT * FROM users WHERE email='$email'");

    if(mysqli_num_rows($check)>0){

        $message="<p class='msg'>Email already exists!</p>";

    }else{

        mysqli_query($conn,

        "INSERT INTO users
        (fullname,student_id,email,password,role)

        VALUES

        ('$fullname',
        '$teacher_id',
        '$email',
        '$password',
        'admin')");

        $message="<p class='success'>Teacher Added Successfully!</p>";

    }

}
?>

<!DOCTYPE html>
<html>

<head>

<title>Add Teacher</title>

<link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>

<?php include("sidebar.php"); ?>

<div class="main">

<?php include("../includes/header.php"); ?>

<h2>Add Teacher</h2><br>

<?php echo $message; ?>

<form method="POST" class="item-form">

<label>Full Name</label>

<input
type="text"
name="fullname"
required>

<label>Teacher ID</label>

<input
type="text"
name="teacher_id"
required>

<label>Email</label>

<input
type="email"
name="email"
required>

<label>Password</label>

<input
type="password"
name="password"
required>

<button
class="btn"
name="add">

Add Teacher

</button>

</form>

<?php include("../includes/footer.php"); ?>
<?php
include("includes/auth.php");
include("config/db.php");

$id = $_SESSION['user_id'];
$message = "";


/* =========================
   GET CURRENT USER
========================= */

$result = mysqli_query(
    $conn,
    "SELECT * FROM users WHERE id='$id'"
);

$user = mysqli_fetch_assoc($result);


/* =========================
   UPDATE PROFILE
========================= */

if(isset($_POST['update'])){

    $fullname = mysqli_real_escape_string(
        $conn,
        trim($_POST['fullname'])
    );

    $email = mysqli_real_escape_string(
        $conn,
        trim($_POST['email'])
    );


    /* Check duplicate email */

    $check = mysqli_query(
        $conn,

        "SELECT id
         FROM users
         WHERE email='$email'
         AND id!='$id'"
    );


    if(mysqli_num_rows($check) > 0){

        $message = "Email already exists!";

    }

    else{

        mysqli_query(
            $conn,

            "UPDATE users
             SET fullname='$fullname',
                 email='$email'
             WHERE id='$id'"
        );


        $message = "Profile updated successfully!";


        /* Reload user */

        $result = mysqli_query(
            $conn,
            "SELECT * FROM users WHERE id='$id'"
        );

        $user = mysqli_fetch_assoc($result);


        /* Update session name */

        $_SESSION['fullname'] = $user['fullname'];

    }

}

?>

<!DOCTYPE html>

<html>

<head>

<title>Edit Profile</title>

<link rel="stylesheet"
      href="assets/css/style.css">

</head>


<body>


<?php include("includes/sidebar.php"); ?>


<div class="main">


<?php include("includes/header.php"); ?>


<h2>Edit Profile</h2>


<?php if($message != ""){ ?>

<p class="msg success">

<?php echo htmlspecialchars($message); ?>

</p>

<?php } ?>


<div class="profile-card">


<form method="POST">


<!-- FULL NAME -->

<div class="form-group">

<label>Full Name</label>

<input
    type="text"
    name="fullname"
    value="<?php echo htmlspecialchars($user['fullname']); ?>"
    required>

</div>


<!-- ID -->

<div class="form-group">

<label>

<?php

if($user['role'] == "admin"){

    echo "Teacher ID";

}else{

    echo "Student ID";

}

?>

</label>


<input
    type="text"
    value="<?php echo htmlspecialchars($user['user_id']); ?>"
    disabled>

</div>


<!-- EMAIL -->

<div class="form-group">

<label>Email</label>

<input
    type="email"
    name="email"
    value="<?php echo htmlspecialchars($user['email']); ?>"
    required>

</div>


<!-- ROLE -->

<div class="form-group">

<label>Role</label>

<input
    type="text"
    value="<?php echo ucfirst($user['role']); ?>"
    disabled>

</div>


<!-- BUTTON -->

<button
    type="submit"
    name="update">

Update Profile

</button>


</form>


</div>


</div>


<?php include("includes/footer.php"); ?>


</body>

</html>
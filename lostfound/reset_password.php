<?php

session_start();

include("config/db.php");

$message = "";
$class = "msg";


/* =========================
   SECURITY CHECK
========================= */

if(
    !isset($_SESSION['reset_user_id']) ||
    !isset($_SESSION['reset_verified']) ||
    $_SESSION['reset_verified'] !== true
){

    header(
        "Location: forgot_password.php"
    );

    exit();

}


$user_id =
(int)$_SESSION['reset_user_id'];


/* =========================
   RESET PASSWORD
========================= */

if(isset($_POST['reset'])){

    $password =
    $_POST['password'];

    $confirm_password =
    $_POST['confirm_password'];


    /* =========================
       PASSWORD VALIDATION
    ========================= */

    if(
        strlen($password) < 6 ||
        !preg_match('/[A-Za-z]/', $password) ||
        !preg_match('/[0-9]/', $password)
    ){

        $message =
        "Password must contain at least 6 characters, including letters and numbers.";

        $class = "msg error";

    }


    elseif(
        $password !== $confirm_password
    ){

        $message =
        "Passwords do not match.";

        $class = "msg error";

    }


    else{


        /* =========================
           HASH PASSWORD
        ========================= */

        $hashed_password =
        password_hash(
            $password,
            PASSWORD_DEFAULT
        );


        /* =========================
           UPDATE PASSWORD
        ========================= */

        $hashed_password_safe =
        mysqli_real_escape_string(
            $conn,
            $hashed_password
        );


        $update = mysqli_query(
            $conn,

            "UPDATE users

             SET password='$hashed_password_safe'

             WHERE id='$user_id'"
        );


        if($update){

            /* Destroy recovery session */

            unset(
                $_SESSION['reset_user_id']
            );

            unset(
                $_SESSION['reset_verified']
            );


            header(
                "Location: login.php?reset=success"
            );

            exit();

        }

        else{

            $message =
            "Unable to reset password.";

            $class = "msg error";

        }

    }

}

?>


<!DOCTYPE html>

<html>

<head>

    <title>Reset Password</title>

    <link rel="stylesheet"
          href="assets/css/style.css">

    <link rel="stylesheet"
          href="assets/css/pages/auth.css">

</head>


<body class="auth-page reset-password-page">


<div class="password-box">


    <h2>Reset Password</h2>


    <?php if($message != ""){ ?>

        <p class="<?php echo $class; ?>">

            <?php
            echo htmlspecialchars($message);
            ?>

        </p>

    <?php } ?>


    <form method="POST">


        <label>
            New Password
        </label>

        <input
            type="password"
            name="password"
            placeholder="New Password"
            required>


        <label>
            Confirm Password
        </label>

        <input
            type="password"
            name="confirm_password"
            placeholder="Confirm New Password"
            required>


        <button
            type="submit"
            name="reset">

            Reset Password

        </button>


    </form>


    <p>

        <a href="login.php">
            Back to Login
        </a>

    </p>


</div>


<?php include("includes/footer.php"); ?>


</body>

</html>
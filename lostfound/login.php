<?php

session_start();

include("config/db.php");

$message = "";

if(isset($_POST['login'])){

    $email = trim($_POST['email']);
    $password = $_POST['password'];


    /* =========================
       FIND USER
    ========================= */

    $email_safe =
    mysqli_real_escape_string($conn, $email);

    $query = mysqli_query(
        $conn,

        "SELECT *
         FROM users
         WHERE email='$email_safe'"
    );


    if(mysqli_num_rows($query) == 1){

        $user = mysqli_fetch_assoc($query);


        /* =========================
           CHECK PASSWORD
        ========================= */

        if(password_verify(
            $password,
            $user['password']
        )){


            /* =========================
               STORE SESSION
            ========================= */

            $_SESSION['user_id'] =
            $user['id'];

            $_SESSION['fullname'] =
            $user['fullname'];

            $_SESSION['role'] =
            $user['role'];


            /* =========================
               ADMIN
            ========================= */

            if($user['role'] == "admin"){

                header(
                    "Location: admin/dashboard.php"
                );

            }


            /* =========================
               STUDENT
            ========================= */

            else{

                /*
                 * Existing accounts created
                 * before security questions
                 * were added may not have
                 * security answers.
                 */

                if(
                    empty($user['security_answer_1']) ||
                    empty($user['security_answer_2']) ||
                    empty($user['security_answer_3'])
                ){

                    header(
                        "Location: setup_security.php"
                    );

                }

                else{

                    header(
                        "Location: dashboard.php"
                    );

                }

            }

            exit();

        }

        else{

            $message =
            "Incorrect password.";

        }

    }

    else{

        $message =
        "User not found.";

    }

}

?>


<!DOCTYPE html>

<html>

<head>

    <title>Login</title>

    <link rel="stylesheet"
          href="assets/css/style.css">

    <link rel="stylesheet"
          href="assets/css/pages/auth.css">

</head>


<body class="auth-page login-page">


<div class="login-layout">


    <!-- LEFT SIDE -->

    <div class="login-intro">

        <h1>LOST &amp; FOUND</h1>

        <img
            src="assets/images/lostfound.png"
            alt="Lost and Found">

        <p>
            Find what was lost.
            Return what was found.
        </p>

    </div>


    <!-- RIGHT SIDE -->

    <div class="auth-box login-box">

        <h2>Log in</h2>


        <?php if($message != ""){ ?>

            <p class="msg">

                <?php
                echo htmlspecialchars($message);
                ?>

            </p>

        <?php } ?>


        <form method="POST">


            <input
                type="email"
                name="email"
                placeholder="Enter your Gmail"
                required>


            <input
                type="password"
                name="password"
                placeholder="Password"
                required>


            <button
                type="submit"
                name="login">

                Log in

            </button>


            <div class="forgot-password">

                <a href="forgot_password.php">

                    Forgot Password?

                </a>

            </div>


        </form>


        <div class="create-account">

            <a href="register.php">

                Create Account

            </a>

        </div>


    </div>


</div>


<?php include("includes/footer.php"); ?>


</body>

</html>
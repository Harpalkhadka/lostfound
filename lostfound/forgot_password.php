<?php

session_start();

include("config/db.php");

$message = "";
$class = "msg";

$show_questions = false;

$user = null;


/* =========================
   STEP 1
   FIND ACCOUNT
========================= */

if(isset($_POST['find_account'])){

    $email =
    trim($_POST['email']);

    $email_safe =
    mysqli_real_escape_string(
        $conn,
        $email
    );


    $result = mysqli_query(
        $conn,

        "SELECT
            id,

            security_question_1,
            security_answer_1,

            security_question_2,
            security_answer_2,

            security_question_3,
            security_answer_3

         FROM users

         WHERE email='$email_safe'"
    );


    if(mysqli_num_rows($result) == 1){

        $user =
        mysqli_fetch_assoc($result);


        /* =========================
           CHECK SECURITY ANSWERS
        ========================= */

        if(
            empty($user['security_answer_1']) ||
            empty($user['security_answer_2']) ||
            empty($user['security_answer_3'])
        ){

            $message =
            "Security questions have not been set for this account.";

            $class = "msg error";

        }

        else{

            $_SESSION['reset_user_id'] =
            $user['id'];

            $show_questions = true;

        }

    }

    else{

        $message =
        "No account found with this Gmail address.";

        $class = "msg error";

    }

}


/* =========================
   STEP 2
   VERIFY ANSWERS
========================= */

if(isset($_POST['verify_answers'])){


    if(
        !isset($_SESSION['reset_user_id'])
    ){

        header(
            "Location: forgot_password.php"
        );

        exit();

    }


    $user_id =
    (int)$_SESSION['reset_user_id'];


    $answer1 =
    strtolower(
        trim($_POST['answer1'])
    );

    $answer2 =
    strtolower(
        trim($_POST['answer2'])
    );

    $answer3 =
    strtolower(
        trim($_POST['answer3'])
    );


    /* =========================
       GET QUESTIONS + ANSWERS
    ========================= */

    $result = mysqli_query(
        $conn,

        "SELECT

            security_question_1,
            security_answer_1,

            security_question_2,
            security_answer_2,

            security_question_3,
            security_answer_3

         FROM users

         WHERE id='$user_id'"
    );


    if(mysqli_num_rows($result) == 1){

        $user =
        mysqli_fetch_assoc($result);


        /* =========================
           VERIFY ANSWERS
        ========================= */

        $correct1 =
        password_verify(
            $answer1,
            $user['security_answer_1']
        );


        $correct2 =
        password_verify(
            $answer2,
            $user['security_answer_2']
        );


        $correct3 =
        password_verify(
            $answer3,
            $user['security_answer_3']
        );


        if(
            $correct1 &&
            $correct2 &&
            $correct3
        ){

            $_SESSION['reset_verified'] =
            true;


            header(
                "Location: reset_password.php"
            );

            exit();

        }

        else{

            $message =
            "One or more answers are incorrect.";

            $class = "msg error";

            $show_questions = true;

        }

    }

}

?>


<!DOCTYPE html>

<html>

<head>

    <title>Forgot Password</title>

    <link rel="stylesheet"
          href="assets/css/style.css">

    <link rel="stylesheet"
          href="assets/css/pages/auth.css">

</head>


<body class="auth-page">


<div class="auth-box">


    <h2>Forgot Password</h2>


    <?php if($message != ""){ ?>

        <p class="<?php echo $class; ?>">

            <?php
            echo htmlspecialchars($message);
            ?>

        </p>

    <?php } ?>


    <?php if(!$show_questions){ ?>


        <!-- =========================
             ENTER GMAIL
        ========================= -->

        <form method="POST">


            <label>
                Gmail Address
            </label><br>


            <input
                type="email"
                name="email"
                placeholder="Enter your Gmail address"
                required><br>


            <button
                type="submit"
                name="find_account">

                Continue

            </button>


        </form>


    <?php } else { ?>


        <!-- =========================
             SECURITY QUESTIONS
        ========================= -->

        <form method="POST">


            <!-- QUESTION 1 -->

            <label>
                Question 1
            </label>

            <div class="security-question">

                <?php
                echo htmlspecialchars(
                    $user['security_question_1']
                );
                ?>

            </div>


            <input
                type="text"
                name="answer1"
                placeholder="Your answer"
                required>


            <!-- QUESTION 2 -->

            <label>
                Question 2
            </label>

            <div class="security-question">

                <?php
                echo htmlspecialchars(
                    $user['security_question_2']
                );
                ?>

            </div>


            <input
                type="text"
                name="answer2"
                placeholder="Your answer"
                required>


            <!-- QUESTION 3 -->

            <label>
                Question 3
            </label>

            <div class="security-question">

                <?php
                echo htmlspecialchars(
                    $user['security_question_3']
                );
                ?>

            </div>


            <input
                type="text"
                name="answer3"
                placeholder="Your answer"
                required>


            <button
                type="submit"
                name="verify_answers">

                Verify Answers

            </button>


        </form>


    <?php } ?>


    <p>

        <a href="login.php">
            Back to Login
        </a>

    </p>


</div>


<?php include("includes/footer.php"); ?>


</body>

</html>
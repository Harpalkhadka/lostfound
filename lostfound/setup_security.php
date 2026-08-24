<?php

session_start();

include("config/db.php");


/* =========================
   CHECK LOGIN
========================= */

if(!isset($_SESSION['user_id'])){

    header("Location: login.php");

    exit();

}


$user_id =
(int)$_SESSION['user_id'];


$message = "";

$class = "msg";


/* =========================
   SECURITY QUESTIONS
========================= */

$question1 =
"What was the first fictional character you remember being obsessed with?";

$question2 =
"What was the name of the first place you remember going on a trip without your parents?";

$question3 =
"What was the first thing you bought with your own money?";


/* =========================
   SAVE ANSWERS
========================= */

if(isset($_POST['save_security'])){

    $answer1 =
    trim($_POST['answer1']);

    $answer2 =
    trim($_POST['answer2']);

    $answer3 =
    trim($_POST['answer3']);


    /* =========================
       CHECK EMPTY
    ========================= */

    if(
        $answer1 == "" ||
        $answer2 == "" ||
        $answer3 == ""
    ){

        $message =
        "Please answer all three questions.";

        $class = "msg error";

    }

    else{


        /* =========================
           HASH ANSWERS
        ========================= */

        $hash1 = password_hash(
            strtolower($answer1),
            PASSWORD_DEFAULT
        );

        $hash2 = password_hash(
            strtolower($answer2),
            PASSWORD_DEFAULT
        );

        $hash3 = password_hash(
            strtolower($answer3),
            PASSWORD_DEFAULT
        );


        /* =========================
           ESCAPE QUESTIONS
        ========================= */

        $question1_safe =
        mysqli_real_escape_string(
            $conn,
            $question1
        );

        $question2_safe =
        mysqli_real_escape_string(
            $conn,
            $question2
        );

        $question3_safe =
        mysqli_real_escape_string(
            $conn,
            $question3
        );


        /* =========================
           UPDATE USER
        ========================= */

        $update = mysqli_query(
            $conn,

            "UPDATE users

             SET
                security_question_1='$question1_safe',
                security_answer_1='$hash1',

                security_question_2='$question2_safe',
                security_answer_2='$hash2',

                security_question_3='$question3_safe',
                security_answer_3='$hash3'

             WHERE id='$user_id'"
        );


        if($update){

            header(
                "Location: dashboard.php"
            );

            exit();

        }

        else{

            $message =
            "Unable to save security answers.";

            $class = "msg error";

        }

    }

}

?>


<!DOCTYPE html>

<html>

<head>

    <title>Security Questions</title>

    <link rel="stylesheet"
          href="assets/css/style.css">

    <link rel="stylesheet"
          href="assets/css/pages/auth.css">

</head>


<body class="auth-page">


<div class="auth-box">


    <h2>Security Questions</h2>


    <p>

        For account security, please answer
        all three questions.

        <br>

        These answers will be used if you
        forget your password.

    </p>


    <?php if($message != ""){ ?>

        <p class="<?php echo $class; ?>">

            <?php
            echo htmlspecialchars($message);
            ?>

        </p>

    <?php } ?>


    <form method="POST">


        <!-- QUESTION 1 -->

        <label>
            Question 1
        </label>

        <div class="security-question">

            <?php
            echo htmlspecialchars($question1);
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
            echo htmlspecialchars($question2);
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
            echo htmlspecialchars($question3);
            ?>

        </div>

        <input
            type="text"
            name="answer3"
            placeholder="Your answer"
            required>


        <button
            type="submit"
            name="save_security">

            Save Security Answers

        </button>


    </form>


</div>


<?php include("includes/footer.php"); ?>


</body>

</html>
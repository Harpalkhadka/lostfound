<?php

include("config/db.php");

$message = "";
$class = "msg";

if(isset($_POST['register'])){

    $fullname = trim($_POST['fullname']);
    $user_id = trim($_POST['user_id']);
    $email = trim($_POST['email']);

    $password_raw = $_POST['password'];

    $answer1_raw = trim($_POST['security_answer_1']);
    $answer2_raw = trim($_POST['security_answer_2']);
    $answer3_raw = trim($_POST['security_answer_3']);


    /* =========================
       ID VALIDATION
    ========================= */

    if(!preg_match('/^[0-9]+$/', $user_id)){

        $message = "Student ID must contain numbers only.";

    }


    /* =========================
       GMAIL VALIDATION
    ========================= */

    elseif(!preg_match('/^[a-z0-9._%+-]+@gmail\.com$/', $email)){

        $message = "Please use a valid Gmail address.";

    }


    /* =========================
       PASSWORD VALIDATION
    ========================= */

    elseif(
        !preg_match(
            '/^(?=.*[A-Za-z])(?=.*[0-9]).{6,}$/',
            $password_raw
        )
    ){

        $message =
        "Password must contain letters and numbers and be at least 6 characters.";

    }


    /* =========================
       SECURITY ANSWERS
    ========================= */

    elseif(
        $answer1_raw == "" ||
        $answer2_raw == "" ||
        $answer3_raw == ""
    ){

        $message = "Please answer all three security questions.";

    }


    else{

        $email_safe =
        mysqli_real_escape_string($conn, $email);

        $user_id_safe =
        mysqli_real_escape_string($conn, $user_id);

        $fullname_safe =
        mysqli_real_escape_string($conn, $fullname);


        /* =========================
           CHECK EMAIL + USER ID
        ========================= */

        $check = mysqli_query(
            $conn,

            "SELECT id
             FROM users
             WHERE email='$email_safe'
             OR user_id='$user_id_safe'"
        );


        if(mysqli_num_rows($check) > 0){

            $message =
            "Email or Student ID already exists.";

        }


        else{

            /* =========================
               PASSWORD HASH
            ========================= */

            $password = password_hash(
                $password_raw,
                PASSWORD_DEFAULT
            );


            /* =========================
               SECURITY ANSWER HASH
            ========================= */

            $answer1 = password_hash(
                strtolower($answer1_raw),
                PASSWORD_DEFAULT
            );

            $answer2 = password_hash(
                strtolower($answer2_raw),
                PASSWORD_DEFAULT
            );

            $answer3 = password_hash(
                strtolower($answer3_raw),
                PASSWORD_DEFAULT
            );


            /* =========================
               SECURITY QUESTIONS
            ========================= */

            $question1 =
            "What was the first fictional character you remember being obsessed with?";

            $question2 =
            "What was the name of the first place you remember going on a trip without your parents?";

            $question3 =
            "What was the first thing you bought with your own money?";


            $question1_safe =
            mysqli_real_escape_string($conn, $question1);

            $question2_safe =
            mysqli_real_escape_string($conn, $question2);

            $question3_safe =
            mysqli_real_escape_string($conn, $question3);


            /* =========================
               INSERT USER
            ========================= */

            $sql = "INSERT INTO users
            (
                fullname,
                user_id,
                email,
                password,
                role,
                security_question_1,
                security_answer_1,
                security_question_2,
                security_answer_2,
                security_question_3,
                security_answer_3
            )
            VALUES
            (
                '$fullname_safe',
                '$user_id_safe',
                '$email_safe',
                '$password',
                'student',
                '$question1_safe',
                '$answer1',
                '$question2_safe',
                '$answer2',
                '$question3_safe',
                '$answer3'
            )";


            if(mysqli_query($conn, $sql)){

                $message =
                "Registration Successful! You can now log in.";

                $class = "msg success";

            }

            else{

                $message =
                "Registration Failed: " .
                mysqli_error($conn);

                $class = "msg error";

            }

        }

    }

}

?>


<!DOCTYPE html>

<html>

<head>

    <title>Register</title>

    <link rel="stylesheet"
          href="assets/css/style.css">

    <link rel="stylesheet"
          href="assets/css/pages/auth.css">

</head>


<body class="auth-page">


<div class="auth-box">

    <h2>Create Account</h2>


    <?php if($message != ""){ ?>

        <p class="<?php echo $class; ?>">

            <?php echo htmlspecialchars($message); ?>

        </p>

    <?php } ?>


    <form method="POST">


        <!-- FULL NAME -->

        <input
            type="text"
            name="fullname"
            placeholder="Full Name"
            required>


        <!-- STUDENT ID -->

        <input
            type="text"
            name="user_id"
            placeholder="Student/Teacher ID"
            required>


        <!-- EMAIL -->

        <input
            type="email"
            name="email"
            placeholder="Gmail Address"
            required>


        <!-- PASSWORD -->

        <input
            type="password"
            name="password"
            placeholder="Password"
            required>


        <!-- SECURITY QUESTION 1 -->

        <label>Security Question 1</label>

        <div class="security-question">

            What was the first fictional character you remember being obsessed with?

        </div>

        <input
            type="text"
            name="security_answer_1"
            placeholder="Your answer"
            required>


        <!-- SECURITY QUESTION 2 -->

        <label>Security Question 2</label>

        <div class="security-question">

            What was the name of the first place you remember going on a trip without your parents?

        </div>

        <input
            type="text"
            name="security_answer_2"
            placeholder="Your answer"
            required>


        <!-- SECURITY QUESTION 3 -->

        <label>Security Question 3</label>

        <div class="security-question">

            What was the first thing you bought with your own money?

        </div>

        <input
            type="text"
            name="security_answer_3"
            placeholder="Your answer"
            required>


        <!-- REGISTER -->

        <button
            type="submit"
            name="register">

            Register

        </button>


    </form>


    <p>

        Already have an account?

        <a href="login.php">
            Login
        </a>

    </p>


</div>


<?php include("includes/footer.php"); ?>


</body>

</html>
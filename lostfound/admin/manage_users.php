<?php
include("../includes/auth.php");
include("../config/db.php");

// Only admins can access this page
if($_SESSION['role'] != "admin"){
    header("Location: ../dashboard.php");
    exit();
}

// Delete user
if(isset($_GET['delete'])){
    $id = (int)$_GET['delete'];

    // Prevent admin from deleting themselves
    if($id != $_SESSION['user_id']){
        mysqli_query($conn, "DELETE FROM users WHERE id='$id'");
    }

    header("Location: manage_users.php");
    exit();
}

// Change role
if(isset($_GET['role']) && isset($_GET['id'])){

    $id = (int)$_GET['id'];
    $role = $_GET['role'];

    if($role == "student" || $role == "admin"){
        mysqli_query($conn,
        "UPDATE users SET role='$role' WHERE id='$id'");
    }

    header("Location: manage_users.php");
    exit();
}

$search = "";

if(isset($_GET['search'])){
    $search = mysqli_real_escape_string($conn, $_GET['search']);
}

$result = mysqli_query($conn,

"SELECT *
FROM users
WHERE
fullname LIKE '%$search%'
OR
email LIKE '%$search%'
ORDER BY fullname ASC");

?>

<!DOCTYPE html>
<html>

<head>

    <title>Manage Users</title>

    <link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>

<?php include("sidebar.php"); ?>

<div class="main">

<?php include("../includes/header.php"); ?>

<h2>Manage Users</h2><br>

<p style="margin-bottom:20px;">
    Total Users:
    <b><?php echo mysqli_num_rows($result); ?></b>
</p>

<form method="GET" class="search-box">

    <input
        type="text"
        name="search"
        placeholder="Search User"
        value="<?php echo htmlspecialchars($search); ?>">

    <button class="btn">
        Search
    </button>

</form>

<table>

<tr>

    <th>S.N.</th>
    <th>Name</th>
    <th>User ID</th>
    <th>Email</th>
    <th>Role</th>
    <th>Registered</th>
    <th>Action</th>

</tr>

<?php

$sn = 1;

while($user = mysqli_fetch_assoc($result)){

?>

<tr>

    <td><?php echo $sn++; ?></td>

    <td><?php echo htmlspecialchars($user['fullname']); ?></td>

    <td><?php echo htmlspecialchars($user['user_id']); ?></td>

    <td><?php echo htmlspecialchars($user['email']); ?></td>

    <td>

        <?php
        if($user['role']=="admin"){
            echo "<span class='badge badge-admin'>Teacher</span>";
        }else{
            echo "<span class='badge badge-student'>Student</span>";
        }
        ?>

    </td>

    <td>

        <?php
        echo date("d M Y", strtotime($user['created_at']));
        ?>

    </td>

    <td>

        <?php if($user['role']=="student"){ ?>

            <a class="btn"
               href="?id=<?php echo $user['id']; ?>&role=admin">

                Make Teacher

            </a>

        <?php }else{ ?>

            <a class="btn"
               href="?id=<?php echo $user['id']; ?>&role=student">

                Make Student

            </a>

        <?php } ?>

        <?php if($user['id'] != $_SESSION['user_id']){ ?>

            <a class="btn"
               onclick="return confirm('Delete this user?')"
               href="?delete=<?php echo $user['id']; ?>">

                Delete

            </a>

        <?php }else{ ?>

            <span style="color:red;font-weight:bold;">
                Current User
            </span>

        <?php } ?>

    </td>

</tr>

<?php } ?>

</table>
<?php include("../includes/footer.php"); ?>
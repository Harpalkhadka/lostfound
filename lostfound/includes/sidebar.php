<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$role = $_SESSION['role'] ?? '';

?>

<div class="sidebar">

<?php if ($role == "admin") { ?>

    <!-- =========================
         ADMIN / TEACHER SIDEBAR
    ========================== -->

    <h2>Admin Panel</h2>

    <a href="/lostfound/admin/dashboard.php">
         Dashboard
    </a>

    <a href="/lostfound/admin/reports.php">
         Reports
    </a>

    <a href="/lostfound/admin/manage_users.php">
         Manage Users
    </a>

    <a href="/lostfound/admin/manage_items.php">
         Manage Items
    </a>

    <a href="/lostfound/admin/manage_claims.php">
         Manage Claims
    </a>

    <a href="/lostfound/admin/add_admin.php">
         Add Teacher
    </a>

    <a href="/lostfound/logout.php">
         Logout
    </a>


<?php } else { ?>

    <!-- =========================
         STUDENT SIDEBAR
    ========================== -->

    <h2>Lost & Found</h2>

    <a href="/lostfound/dashboard.php">
         Dashboard
    </a>

    <a href="/lostfound/profile.php">
         My Profile
    </a>

    <a href="/lostfound/report_lost.php">
         Report Lost Item
    </a>

    <a href="/lostfound/report_found.php">
         Report Found Item
    </a>

    <a href="/lostfound/browse.php">
         Browse Items
    </a>

    <a href="/lostfound/my_reports.php">
         My Reports
    </a>

    <a href="/lostfound/my_claims.php">
         My Claims
    </a>

    <a href="/lostfound/logout.php">
         Logout
    </a>

<?php } ?>

</div>
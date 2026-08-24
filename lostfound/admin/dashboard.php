<?php

include("auth.php");
include("../config/db.php");


/* =========================
   ADMIN CHECK
========================= */

if($_SESSION['role'] != "admin"){

    header("Location: ../dashboard.php");
    exit();

}


/* =========================
   TOTAL USERS
========================= */

$users_query = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total FROM users"
);

$users = mysqli_fetch_assoc($users_query)['total'];


/* =========================
   TOTAL ITEMS
========================= */

$items_query = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total FROM items"
);

$items = mysqli_fetch_assoc($items_query)['total'];


/* =========================
   TOTAL CLAIMS
========================= */

$claims_query = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total FROM claims"
);

$claims = mysqli_fetch_assoc($claims_query)['total'];


/* =========================
   LOST ITEMS
========================= */

$lost_query = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM items
     WHERE item_type='lost'"
);

$lost = mysqli_fetch_assoc($lost_query)['total'];


/* =========================
   FOUND ITEMS
========================= */

$found_query = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM items
     WHERE item_type='found'"
);

$found = mysqli_fetch_assoc($found_query)['total'];


/* =========================
   RECOVERED ITEMS
========================= */

$recovered_query = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM items
     WHERE status='recovered'"
);

$recovered = mysqli_fetch_assoc($recovered_query)['total'];

?>

<!DOCTYPE html>

<html>

<head>

    <title>Admin Dashboard</title>

    <link rel="stylesheet" href="../assets/css/style.css">

</head>


<body>


<div class="sidebar">

    <h2>Admin Panel</h2>

    <a href="dashboard.php">Dashboard</a>

    <a href="reports.php">Reports</a>

    <a href="manage_users.php">Manage Users</a>

    <a href="manage_items.php">Manage Items</a>

    <a href="manage_claims.php">Manage Claims</a>

    <a href="../logout.php">Logout</a>

</div>


<div class="main">


    <!-- =========================
         WELCOME
    ========================== -->

    <div class="dashboard-welcome">

        <h1>

            Hello,
            <?php echo htmlspecialchars($_SESSION['fullname']); ?>

            <span class="welcome-icon">

                <svg width="30"
                     height="30"
                     viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2"
                     stroke-linecap="round"
                     stroke-linejoin="round">

                    <path d="M8 13l-1-1a2 2 0 0 1 3-3l2 2"/>
                    <path d="M12 11l1-1a2 2 0 0 1 3 3l-4 4"/>
                    <path d="M9 15l-2-2"/>
                    <path d="M12 18l-3-3"/>
                    <path d="M15 15l-2-2"/>

                </svg>

            </span>

        </h1>

        <p>
            Here's an overview of your Lost & Found system.
        </p>

    </div>


    <!-- =========================
         STATISTICS
    ========================== -->

    <div class="cards dashboard-cards">


        <!-- USERS -->

        <div class="card dashboard-card">

            <div class="dashboard-icon users-icon">

                <svg viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2"
                     stroke-linecap="round"
                     stroke-linejoin="round">

                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>

                </svg>

            </div>

            <h2>Total Users</h2>

            <p class="card-number">
                <?php echo $users; ?>
            </p>

            <span>
                Registered users
            </span>

        </div>


        <!-- ITEMS -->

        <div class="card dashboard-card">

            <div class="dashboard-icon items-icon">

                <svg viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2"
                     stroke-linecap="round"
                     stroke-linejoin="round">

                    <path d="M21 8l-9-5-9 5 9 5 9-5z"/>
                    <path d="M3 8v8l9 5 9-5V8"/>
                    <path d="M12 13v8"/>

                </svg>

            </div>

            <h2>Total Items</h2>

            <p class="card-number">
                <?php echo $items; ?>
            </p>

            <span>
                Reported items
            </span>

        </div>


        <!-- CLAIMS -->

        <div class="card dashboard-card">

            <div class="dashboard-icon claim-icon">

                <svg viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2"
                     stroke-linecap="round"
                     stroke-linejoin="round">

                    <path d="M20 7h-4V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
                    <path d="M8 7h8"/>
                    <path d="M9 13h6"/>

                </svg>

            </div>

            <h2>Total Claims</h2>

            <p class="card-number">
                <?php echo $claims; ?>
            </p>

            <span>
                Submitted claims
            </span>

        </div>


        <!-- LOST -->

        <div class="card dashboard-card">

            <div class="dashboard-icon lost-icon">

                <svg viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2"
                     stroke-linecap="round"
                     stroke-linejoin="round">

                    <circle cx="12" cy="12" r="9"/>
                    <path d="M12 8v4"/>
                    <path d="M12 16h.01"/>

                </svg>

            </div>

            <h2>Lost Items</h2>

            <p class="card-number">
                <?php echo $lost; ?>
            </p>

            <span>
                Items reported lost
            </span>

        </div>


        <!-- FOUND -->

        <div class="card dashboard-card">

            <div class="dashboard-icon found-icon">

                <svg viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2"
                     stroke-linecap="round"
                     stroke-linejoin="round">

                    <path d="M20 12v7a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h8"/>
                    <path d="M16 3v6h6"/>
                    <path d="M16 3l6 6"/>

                </svg>

            </div>

            <h2>Found Items</h2>

            <p class="card-number">
                <?php echo $found; ?>
            </p>

            <span>
                Items reported found
            </span>

        </div>


        <!-- RECOVERED -->

        <div class="card dashboard-card">

            <div class="dashboard-icon recovered-icon">

                <svg viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2"
                     stroke-linecap="round"
                     stroke-linejoin="round">

                    <path d="M20 6L9 17l-5-5"/>

                </svg>

            </div>

            <h2>Recovered</h2>

            <p class="card-number">
                <?php echo $recovered; ?>
            </p>

            <span>
                Successfully recovered
            </span>

        </div>


    </div>


    <!-- =========================
         QUICK ACTIONS
    ========================== -->

    <div class="quick-section">

        <h2>Quick Actions</h2>

        <p class="quick-description">
            Manage your Lost & Found system.
        </p>


        <div class="quick-actions">


            <!-- USERS -->

            <a href="manage_users.php" class="quick-action">

                <span class="quick-icon">

                    <svg viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="2"
                         stroke-linecap="round"
                         stroke-linejoin="round">

                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>

                    </svg>

                </span>

                <div>

                    <strong>Manage Users</strong>

                    <small>
                        View and manage registered users.
                    </small>

                </div>

            </a>


            <!-- ITEMS -->

            <a href="manage_items.php" class="quick-action">

                <span class="quick-icon">

                    <svg viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="2"
                         stroke-linecap="round"
                         stroke-linejoin="round">

                        <path d="M21 8l-9-5-9 5 9 5 9-5z"/>
                        <path d="M3 8v8l9 5 9-5V8"/>
                        <path d="M12 13v8"/>

                    </svg>

                </span>

                <div>

                    <strong>Manage Items</strong>

                    <small>
                        Review reported lost and found items.
                    </small>

                </div>

            </a>


            <!-- CLAIMS -->

            <a href="manage_claims.php" class="quick-action">

                <span class="quick-icon">

                    <svg viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="2"
                         stroke-linecap="round"
                         stroke-linejoin="round">

                        <path d="M20 7h-4V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
                        <path d="M9 13h6"/>

                    </svg>

                </span>

                <div>

                    <strong>Review Claims</strong>

                    <small>
                        Check submitted claims and evidence.
                    </small>

                </div>

            </a>


            <!-- REPORTS -->

            <a href="reports.php" class="quick-action">

                <span class="quick-icon">

                    <svg viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="2"
                         stroke-linecap="round"
                         stroke-linejoin="round">

                        <path d="M4 19V5"/>
                        <path d="M4 19h16"/>
                        <path d="M8 16v-5"/>
                        <path d="M12 16V8"/>
                        <path d="M16 16v-3"/>
                        <path d="M20 16V6"/>

                    </svg>

                </span>

                <div>

                    <strong>View Reports</strong>

                    <small>
                        See system statistics and activity.
                    </small>

                </div>

            </a>


        </div>

    </div>


    <?php include("../includes/footer.php"); ?>


</div>


</body>

</html>
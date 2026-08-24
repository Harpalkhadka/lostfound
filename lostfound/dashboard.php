<?php

include("includes/auth.php");
include("config/db.php");

$user_id = $_SESSION['user_id'];


/* =========================
   LOST ITEMS
========================= */

$lost_query = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM items
     WHERE user_id='$user_id'
     AND item_type='lost'"
);

$lost_items = mysqli_fetch_assoc($lost_query)['total'];


/* =========================
   FOUND ITEMS
========================= */

$found_query = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM items
     WHERE user_id='$user_id'
     AND item_type='found'"
);

$found_items = mysqli_fetch_assoc($found_query)['total'];


/* =========================
   MY CLAIMS
========================= */

$claim_query = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM claims
     WHERE user_id='$user_id'"
);

$my_claims = mysqli_fetch_assoc($claim_query)['total'];

?>

<!DOCTYPE html>

<html>

<head>

    <title>Student Dashboard</title>

    <link rel="stylesheet" href="assets/css/style.css">

</head>


<body>


<?php include("includes/sidebar.php"); ?>


<div class="main">


    <?php include("includes/header.php"); ?>


    <!-- =========================
         WELCOME
    ========================== -->

    <div class="dashboard-welcome">

        <h1>
            Hello,
            <?php echo htmlspecialchars($_SESSION['fullname']); ?>
            <span class="welcome-icon">

                <svg width="30" height="30" viewBox="0 0 24 24"
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
            Welcome to your Lost & Found dashboard.
        </p>

    </div>


    <!-- =========================
         STUDENT STATISTICS
    ========================== -->

    <div class="cards dashboard-cards student-dashboard-cards">


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
                <?php echo $lost_items; ?>
            </p>

            <span>
                Items you reported lost
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
                <?php echo $found_items; ?>
            </p>

            <span>
                Items you reported found
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

            <h2>My Claims</h2>

            <p class="card-number">
                <?php echo $my_claims; ?>
            </p>

            <span>
                Claims you have submitted
            </span>

        </div>


    </div>


    <!-- =========================
         QUICK ACTIONS
    ========================== -->

    <div class="quick-section">

        <h2>What would you like to do?</h2>

        <p class="quick-description">
            Quickly access the main features of the system.
        </p>


        <div class="quick-actions">


            <!-- REPORT LOST -->

            <a href="report_lost.php" class="quick-action">

                <span class="quick-icon">

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

                </span>

                <div>

                    <strong>Report Lost Item</strong>

                    <small>
                        Report something you have lost.
                    </small>

                </div>

            </a>


            <!-- REPORT FOUND -->

            <a href="report_found.php" class="quick-action">

                <span class="quick-icon">

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

                </span>

                <div>

                    <strong>Report Found Item</strong>

                    <small>
                        Help someone find their item.
                    </small>

                </div>

            </a>


            <!-- BROWSE -->

            <a href="browse.php" class="quick-action">

                <span class="quick-icon">

                    <svg viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="2"
                         stroke-linecap="round"
                         stroke-linejoin="round">

                        <circle cx="11" cy="11" r="7"/>
                        <path d="M20 20l-4-4"/>

                    </svg>

                </span>

                <div>

                    <strong>Browse Items</strong>

                    <small>
                        Search lost and found items.
                    </small>

                </div>

            </a>


            <!-- MY REPORTS -->

            <a href="my_reports.php" class="quick-action">

                <span class="quick-icon">

                    <svg viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="2"
                         stroke-linecap="round"
                         stroke-linejoin="round">

                        <path d="M6 2h9l5 5v15H6z"/>
                        <path d="M14 2v6h6"/>
                        <path d="M9 13h6"/>
                        <path d="M9 17h6"/>

                    </svg>

                </span>

                <div>

                    <strong>My Reports</strong>

                    <small>
                        View your reported items.
                    </small>

                </div>

            </a>


        </div>

    </div>


    <?php include("includes/footer.php"); ?>


</div>


</body>

</html>
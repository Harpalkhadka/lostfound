<?php

include("auth.php");
include("../config/db.php");


/* Get claim ID */

if(!isset($_GET['id'])){
    header("Location: manage_claims.php");
    exit();
}

$id = (int)$_GET['id'];


/* Get claim + item + student information */

$sql = "SELECT
            claims.*,

            items.item_name,
            items.category,
            items.description AS item_description,
            items.location AS item_location,
            items.image AS item_image,
            items.item_type,
            items.status AS item_status,

            users.fullname,
            users.email

        FROM claims

        JOIN items
        ON claims.item_id = items.id

        JOIN users
        ON claims.user_id = users.id

        WHERE claims.id = '$id'";


$result = mysqli_query($conn, $sql);


if(!$result || mysqli_num_rows($result) == 0){

    echo "Claim not found.";
    exit();

}


$row = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>

<html>

<head>

    <title>Claim Details</title>

    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/admin.css">

</head>


<body>


<div class="sidebar">

    <h2>Admin Panel</h2>

    <a href="dashboard.php">Dashboard</a>

    <a href="manage_items.php">Manage Items</a>

    <a href="manage_claims.php">Manage Claims</a>

</div>


<div class="main">


    <div class="claim-details-page">


        <div class="details-header">

            <h2>Claim Details</h2><br>

            <a
                href="manage_claims.php"
                class="btn"
            >
                ← Back<br>
            </a>

        </div>


        <!-- ==========================================
             CLAIMANT INFORMATION
        ========================================== -->

        <div class="details-section">

            <h3>Claimant Information</h3>


            <div class="detail-row">

                <strong>Name:</strong>

                <span>
                    <?php echo htmlspecialchars($row['fullname']); ?>
                </span>

            </div>


            <div class="detail-row">

                <strong>Email:</strong>

                <span>
                    <?php echo htmlspecialchars($row['email']); ?>
                </span>

            </div>


            <div class="detail-row">

                <strong>Phone:</strong>

                <span>
                    <?php echo htmlspecialchars($row['phone']); ?>
                </span>

            </div>

        </div>


        <!-- ==========================================
             CLAIMED ITEM
        ========================================== -->

        <div class="details-section">

            <h3>Claimed Item</h3>


            <div class="detail-row">

                <strong>Item Name:</strong>

                <span>
                    <?php echo htmlspecialchars($row['item_name']); ?>
                </span>

            </div>


            <div class="detail-row">

                <strong>Category:</strong>

                <span>
                    <?php echo htmlspecialchars($row['category']); ?>
                </span>

            </div>


            <div class="detail-row">

                <strong>Item Type:</strong>

                <span>
                    <?php echo ucfirst(htmlspecialchars($row['item_type'])); ?>
                </span>

            </div>


            <div class="detail-row">

                <strong>Location:</strong>

                <span>
                    <?php echo htmlspecialchars($row['item_location']); ?>
                </span>

            </div>


            <div class="description-box">

                <strong>Original Item Description</strong>

                <p>
                    <?php
                    echo nl2br(
                        htmlspecialchars($row['item_description'])
                    );
                    ?>
                </p>

            </div>


            <?php if(!empty($row['item_image'])){ ?>

                <div class="evidence-box">

                    <h4>Original Item Image</h4>

                    <img
                        src="../assets/uploads/<?php echo htmlspecialchars($row['item_image']); ?>"
                        class="claim-image"
                        alt="Original Item Image"
                    >

                </div>

            <?php } ?>


        </div>


        <!-- ==========================================
             CLAIM INFORMATION
        ========================================== -->

        <div class="details-section">

            <h3>Claim Information</h3>


            <div class="detail-row">

                <strong>Lost Location:</strong>

                <span>
                    <?php echo htmlspecialchars($row['lost_location']); ?>
                </span>

            </div>


            <div class="detail-row">

                <strong>Lost Date:</strong>

                <span>
                    <?php echo htmlspecialchars($row['lost_date']); ?>
                </span>

            </div>


            <div class="detail-row">

                <strong>Item Color:</strong>

                <span>
                    <?php echo htmlspecialchars($row['item_color']); ?>
                </span>

            </div>


            <div class="detail-row">

                <strong>Brand:</strong>

                <span>
                    <?php echo htmlspecialchars($row['brand']); ?>
                </span>

            </div>


            <div class="description-box">

                <strong>Unique Marks</strong>

                <p>
                    <?php
                    echo nl2br(
                        htmlspecialchars($row['unique_marks'])
                    );
                    ?>
                </p>

            </div>


            <div class="description-box">

                <strong>Items Inside</strong>

                <p>
                    <?php
                    echo nl2br(
                        htmlspecialchars($row['items_inside'])
                    );
                    ?>
                </p>

            </div>


            <div class="description-box">

                <strong>Additional Details</strong>

                <p>
                    <?php
                    echo nl2br(
                        htmlspecialchars($row['additional_details'])
                    );
                    ?>
                </p>

            </div>


        </div>


        <!-- ==========================================
             PROOF IMAGE
        ========================================== -->

        <div class="details-section">

            <h3>Proof / Evidence</h3>


            <?php if(!empty($row['proof_image'])){ ?>

                <div class="proof-image-container">

                  <img
    src="../assets/uploads/<?php echo htmlspecialchars($row['proof_image']); ?>"
    class="proof-image">
                </div>

            <?php }else{ ?>

                <p class="no-proof">
                    No proof image was submitted.
                </p>

            <?php } ?>


        </div>


        <!-- ==========================================
             ACTIONS
        ========================================== -->

        <div class="claim-actions">


            <a
                class="btn btn-approve"
                href="approve_claim.php?id=<?php echo $row['id']; ?>"
                onclick="return confirm('Approve this claim?')"
            >
                Approve Claim
            </a>


            <a
                class="btn btn-reject"
                href="reject_claim.php?id=<?php echo $row['id']; ?>"
                onclick="return confirm('Reject this claim?')"
            >
                Reject Claim
            </a>


        </div>


    </div>


    <?php include("../includes/footer.php"); ?>


</div>


</body>

</html>
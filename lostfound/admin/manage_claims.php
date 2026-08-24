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
   APPROVE CLAIM
========================= */

if(isset($_GET['approve'])){

    $claim_id = (int)$_GET['approve'];

    /* Get claim */

    $claim_query = mysqli_query(
        $conn,
        "SELECT * FROM claims
         WHERE id='$claim_id'"
    );

    $claim = mysqli_fetch_assoc($claim_query);

    if($claim){

        $item_id = (int)$claim['item_id'];

        /* Approve claim */

      mysqli_query(
    $conn,
    "UPDATE claims
     SET claim_status='Approved'
     WHERE id='$claim_id'"
);

        /* Mark item as recovered */

        mysqli_query(
            $conn,
            "UPDATE items
             SET status='recovered'
             WHERE id='$item_id'"
        );

    }

    header("Location: manage_claims.php");
    exit();

}


/* =========================
   REJECT CLAIM
========================= */

if(isset($_GET['reject'])){

    $claim_id = (int)$_GET['reject'];

 mysqli_query(
    $conn,
    "UPDATE claims
     SET claim_status='Rejected'
     WHERE id='$claim_id'"
);

    header("Location: manage_claims.php");
    exit();

}


/* =========================
   GET ALL CLAIMS
========================= */

$result = mysqli_query(
    $conn,

    "SELECT
        claims.*,
        items.item_name,
        items.category,
        items.item_type,
        users.fullname

     FROM claims

     JOIN items
     ON claims.item_id = items.id

     JOIN users
     ON claims.user_id = users.id

     ORDER BY claims.created_at DESC"
);

?>


<!DOCTYPE html>

<html>

<head>

    <title>Manage Claims</title>

    <link rel="stylesheet" href="../assets/css/style.css">

    <link rel="stylesheet" href="../assets/css/admin.css">

</head>


<body>


<?php include("../includes/sidebar.php"); ?>


<div class="main">


<?php include("../includes/header.php"); ?>


<h2>Manage Claims</h2><br>


<table class="admin-table">


<tr>

    <th>SN</th>

    <th>Item</th>

    <th>Category</th>

    <th>Claimed By</th>

    <th>Type</th>

    <th>Status</th>

    <th>Action</th>

</tr>


<?php

$sn = 1;


if(mysqli_num_rows($result) > 0){

    while($row = mysqli_fetch_assoc($result)){

?>


<tr>


    <!-- SN -->

    <td>

        <?php echo $sn++; ?>

    </td>


    <!-- ITEM -->

    <td>

        <?php echo htmlspecialchars($row['item_name']); ?>

    </td>


    <!-- CATEGORY -->

    <td>

        <?php echo htmlspecialchars($row['category']); ?>

    </td>


    <!-- CLAIMED BY -->

    <td>

        <?php echo htmlspecialchars($row['fullname']); ?>

    </td>


    <!-- TYPE -->

    <td>

        <?php echo ucfirst($row['item_type']); ?>

    </td>


    <!-- STATUS -->

    <td>

     <?php

if($row['claim_status'] == "Pending"){

    echo "<span class='badge badge-pending'>Pending</span>";

}

elseif($row['claim_status'] == "Approved"){

    echo "<span class='badge badge-approved'>Approved</span>";

}

elseif($row['claim_status'] == "Rejected"){

    echo "<span class='badge badge-rejected'>Rejected</span>";

}

?>
    </td>


    <!-- ACTION -->
<td>

<a
    class="btn"
    href="view_claim.php?id=<?php echo $row['id']; ?>"
>
    View Details
</a>


<?php if($row['claim_status'] == "pending"){ ?>

<a
    class="btn btn-approve"
    href="approve_claim.php?id=<?php echo $row['id']; ?>"
    onclick="return confirm('Approve this claim?')"
>
    Approve
</a>


<a
    class="btn btn-reject"
    href="reject_claim.php?id=<?php echo $row['id']; ?>"
    onclick="return confirm('Reject this claim?')"
>
    Reject
</a>

<?php }else{ ?>

Completed

<?php } ?>

</td>


</tr>


<?php

    }

}

else{

?>


<tr>

    <td colspan="7">

        No claims have been submitted yet.

    </td>

</tr>


<?php

}

?>


</table>


<?php include("../includes/footer.php"); ?>


</div>


</body>

</html>
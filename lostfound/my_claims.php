<?php

include("includes/auth.php");
include("config/db.php");

$user_id = $_SESSION['user_id'];


/* =========================
   GET MY CLAIMS
========================= */

$result = mysqli_query(
    $conn,
    "SELECT
        claims.*,
        items.item_name,
        items.category,
        items.item_type

     FROM claims

     JOIN items
     ON claims.item_id = items.id

     WHERE claims.user_id = '$user_id'

     ORDER BY claims.created_at DESC"
);

?>

<!DOCTYPE html>
<html>

<head>

    <title>My Claims</title>

    <link rel="stylesheet" href="assets/css/style.css">

</head>

<body>

<?php include("includes/sidebar.php"); ?>

<div class="main">

<?php include("includes/header.php"); ?>

<h2>My Claims</h2><br>

<table>

<tr>

    <th>Item</th>

    <th>Category</th>

    <th>Type</th>

    <th>Status</th>

</tr>


<?php

if(mysqli_num_rows($result) > 0){

    while($row = mysqli_fetch_assoc($result)){

?>

<tr>

    <td>
        <?php echo htmlspecialchars($row['item_name']); ?>
    </td>

    <td>
        <?php echo htmlspecialchars($row['category']); ?>
    </td>

    <td>
        <?php echo ucfirst($row['item_type']); ?>
    </td>

    <td>

        <?php

        if($row['claim_status'] == "pending"){

            echo "<span class='badge badge-active'>Pending</span>";

        }
        elseif($row['claim_status'] == "approved"){

            echo "<span class='badge badge-approved'>Approved</span>";

        }
        elseif($row['claim_status'] == "rejected"){

            echo "<span class='badge badge-rejected'>Rejected</span>";

        }

        ?>

    </td>

</tr>

<?php

    }

}
else{

?>

<tr>

    <td colspan="4">
        You have not submitted any claims yet.
    </td>

</tr>

<?php

}

?>

</table>

<?php include("includes/footer.php"); ?>

</div>

</body>

</html>
<?php

include("auth.php");
include("../config/db.php");

$id=(int)$_GET['id'];

$claim=mysqli_query($conn,

"SELECT * FROM claims
WHERE id='$id'");

$claim=mysqli_fetch_assoc($claim);

mysqli_query($conn,

"UPDATE claims

SET claim_status='Approved'

WHERE id='$id'");

mysqli_query($conn,

"UPDATE items

SET status='recovered'

WHERE id='".$claim['item_id']."'");

header("Location:manage_claims.php");

exit();

?>
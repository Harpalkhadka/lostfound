<?php

include("auth.php");
include("../config/db.php");

$id=(int)$_GET['id'];

mysqli_query($conn,

"UPDATE claims

SET claim_status='Rejected'

WHERE id='$id'");

header("Location:manage_claims.php");

exit();

?>
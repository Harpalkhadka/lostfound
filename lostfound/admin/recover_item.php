<?php

include("auth.php");
include("../config/db.php");

$id=(int)$_GET['id'];

mysqli_query($conn,

"UPDATE items

SET status='recovered'

WHERE id='$id'");

header("Location: manage_items.php");

exit();

?>
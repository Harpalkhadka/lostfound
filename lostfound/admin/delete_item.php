<?php

include("auth.php");
include("../config/db.php");

$id=(int)$_GET['id'];

mysqli_query($conn,

"DELETE FROM items

WHERE id='$id'");

header("Location: manage_items.php");

exit();

?>
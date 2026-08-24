<?php

include("includes/auth.php");
include("config/db.php");

$id=(int)$_GET['id'];

$user=$_SESSION['user_id'];

$sql="DELETE FROM items

WHERE id='$id'

AND user_id='$user'";

mysqli_query($conn,$sql);

header("Location: my_reports.php");

exit();

?>
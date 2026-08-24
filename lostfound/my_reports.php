<?php

include("includes/auth.php");
include("config/db.php");

$user=$_SESSION['user_id'];

$sql="SELECT * FROM items
WHERE user_id='$user'
ORDER BY created_at DESC";

$result=mysqli_query($conn,$sql);

?>

<!DOCTYPE html>

<html>

<head>

<title>My Reports</title>

<link rel="stylesheet"
href="assets/css/style.css">

</head>

<body>

<?php include("includes/sidebar.php"); ?>

<div class="main">

<?php include("includes/header.php"); ?>

<h2>My Reports</h2><br>

<table>

<tr>

<th>Item</th>

<th>Type</th>

<th>Status</th>

<th>Action</th>

</tr>

<?php

while($row=mysqli_fetch_assoc($result))
{

?>

<tr>

<td><?php echo $row['item_name']; ?></td>

<td><?php echo ucfirst($row['item_type']); ?></td>

<td><?php echo ucfirst($row['status']); ?></td>

<td>

<a
href="delete_item.php?id=<?php echo $row['id']; ?>"
onclick="return confirm('Delete this report?')">

Delete

</a>

</td>

</tr>

<?php

}

?>

</table>

<?php include("includes/footer.php"); ?>
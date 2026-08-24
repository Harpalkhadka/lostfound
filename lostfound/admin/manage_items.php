<?php
include("../includes/auth.php");
include("../config/db.php");

if($_SESSION['role'] != "admin"){
    header("Location: ../dashboard.php");
    exit();
}

/* Delete Item */
if(isset($_GET['delete'])){

    $id = (int)$_GET['delete'];

    mysqli_query($conn,
    "DELETE FROM items WHERE id='$id'");

    header("Location: manage_items.php");
    exit();
}

/* Change Status */
if(isset($_GET['status'])){

    $id = (int)$_GET['id'];
    $status = $_GET['status'];

    mysqli_query($conn,
    "UPDATE items
    SET status='$status'
    WHERE id='$id'");

    header("Location: manage_items.php");
    exit();
}

/* Search */

$search = "";

if(isset($_GET['search'])){
    $search = mysqli_real_escape_string($conn, $_GET['search']);
}

$result = mysqli_query($conn, "
SELECT items.*, users.fullname
FROM items
JOIN users
ON items.user_id = users.id
WHERE
item_name LIKE '%$search%'
OR
fullname LIKE '%$search%'
ORDER BY created_at DESC
");
?>

<!DOCTYPE html>
<html>

<head>

<title>Manage Items</title>

<link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>

<?php include("sidebar.php"); ?>

<div class="main">

<?php include("../includes/header.php"); ?>

<h2>Manage Items</h2><br>

<p style="margin-bottom:20px;">
Total Items:
<b><?php echo mysqli_num_rows($result); ?></b>
</p>

<form method="GET" class="search-box">

<input
type="text"
name="search"
placeholder="Search item or owner..."
value="<?php echo htmlspecialchars($search); ?>">

<button class="btn">
Search
</button>

</form>

<table>

<tr>

<th>SN</th>
<th>Image</th>
<th>Item</th>
<th>Owner</th>
<th>Type</th>
<th>Status</th>
<th>Action</th>

</tr>

<?php

$sn = 1;

while($row = mysqli_fetch_assoc($result)){

?>

<tr>

<td><?php echo $sn++; ?></td>

<td>

<?php if(!empty($row['image'])){ ?>

<img
src="../assets/uploads/<?php echo htmlspecialchars($row['image']); ?>"
style="width:90px;height:90px;object-fit:cover;border-radius:8px;"
alt="Item Image">

<?php }else{ ?>

No Image

<?php } ?>
</td>

<td>
<?php echo htmlspecialchars($row['item_name']); ?>
</td>

<td>
<?php echo htmlspecialchars($row['fullname']); ?>
</td>

<td>

<?php
if($row['item_type']=="lost"){
    echo "<span class='badge badge-rejected'>Lost</span>";
}else{
    echo "<span class='badge badge-approved'>Found</span>";
}
?>

</td>

<td>

<span class="badge badge-<?php echo $row['status']; ?>">
<?php echo ucfirst($row['status']); ?>
</span>

</td>

<td>

<a class="btn"
href="edit_item.php?id=<?php echo $row['id']; ?>">
Edit
</a>

<?php if($row['status']=="active"){ ?>

<a class="btn"
href="?id=<?php echo $row['id']; ?>&status=recovered">
Recover
</a>

<?php }else{ ?>

<a class="btn"
href="?id=<?php echo $row['id']; ?>&status=active">
Reopen
</a>

<?php } ?>

<a class="btn"
onclick="return confirm('Delete this item?')"
href="?delete=<?php echo $row['id']; ?>">
Delete
</a>

</td>

</tr>

<?php } ?>

</table>

<?php include("../includes/footer.php"); ?>
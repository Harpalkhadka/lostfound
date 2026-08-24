<?php
include("includes/auth.php");
include("config/db.php");

$user_id = $_SESSION['user_id'];

$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : "";
$category = isset($_GET['category']) ? mysqli_real_escape_string($conn, $_GET['category']) : "";
$type = isset($_GET['type']) ? mysqli_real_escape_string($conn, $_GET['type']) : "";
$location = isset($_GET['location']) ? mysqli_real_escape_string($conn, $_GET['location']) : "";


/* Get all active items */

$sql = "SELECT items.*, users.fullname
FROM items
JOIN users ON items.user_id = users.id
WHERE items.status = 'active'";


/* Search by item name */

if($search != ""){
    $sql .= " AND items.item_name LIKE '%$search%'";
}


/* Filter by category */

if($category != ""){
    $sql .= " AND items.category = '$category'";
}


/* Filter by lost/found type */

if($type != ""){
    $sql .= " AND items.item_type = '$type'";
}


/* Search by location */

if($location != ""){
    $sql .= " AND items.location LIKE '%$location%'";
}


/* Newest items first */

$sql .= " ORDER BY items.created_at DESC";


$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Browse Items</title>
 <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

<?php include("includes/sidebar.php"); ?>

<div class="main">

<?php include("includes/header.php"); ?>

<h2>Browse Lost & Found Items</h2><br>
<form method="GET" class="search-box">

<input
type="text"
name="search"
placeholder="Item Name"
value="<?php echo htmlspecialchars($search); ?>">

<select name="category">

<option value="">All Categories</option>

<option value="Wallet">Wallet</option>
<option value="Phone">Phone</option>
<option value="Laptop">Laptop</option>
<option value="Bag">Bag</option>
<option value="ID Card">ID Card</option>
<option value="Keys">Keys</option>
<option value="Other">Other</option>

</select>

<select name="type">

<option value="">Lost & Found</option>

<option value="lost">Lost</option>

<option value="found">Found</option>

</select>

<input
type="text"
name="location"
placeholder="Location"
value="<?php echo htmlspecialchars($location); ?>">

<button type="submit">
Search
</button>

</form>

<div class="card-container">

<?php

if(mysqli_num_rows($result) > 0){

while($row = mysqli_fetch_assoc($result)){

?>

<div class="item-card">

<?php
if(!empty($row['image'])){
?>

<img src="assets/uploads/<?php echo htmlspecialchars($row['image']); ?>">

<?php
}
?>

<h3><?php echo htmlspecialchars($row['item_name']); ?></h3>

<p><strong>Category:</strong>
<?php echo htmlspecialchars($row['category']); ?></p>

<p><strong>Type:</strong>
<?php echo ucfirst(htmlspecialchars($row['item_type'])); ?></p>

<p><strong>Location:</strong>
<?php echo htmlspecialchars($row['location']); ?></p>

<p><strong>Description:</strong><br>
<?php echo nl2br(htmlspecialchars($row['description'])); ?></p>

<p><strong>Reported By:</strong>
<?php echo htmlspecialchars($row['fullname']); ?></p>

<p><strong>Date:</strong>
<?php echo $row['created_at']; ?></p>

<br>
<?php if($row['item_type'] == "found" && $row['user_id'] != $_SESSION['user_id']){ ?>

<a href="claim_item.php?id=<?php echo $row['id']; ?>" class="btn">
    Claim This Item
</a>

<?php } ?>

</div>

<?php

}

}else{

echo "<p>No items found.</p>";

}

?>

</div>

<?php include("includes/footer.php"); ?>
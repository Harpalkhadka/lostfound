<?php
include("includes/auth.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Report Lost Item</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

<?php include("includes/sidebar.php"); ?>

<div class="main">

<?php include("includes/header.php"); ?>

<h2>Report Lost Item</h2><br>

<form action="save_item.php" method="POST" enctype="multipart/form-data" class="item-form">

<input type="hidden" name="item_type" value="lost">

<label>Item Name</label>
<input type="text" name="item_name" required>

<label>Category</label>

<select name="category" required>

<option value="">Select Category</option>

<option>Mobile Phone</option>
<option>Laptop</option>
<option>Wallet</option>
<option>ID Card</option>
<option>Bag</option>
<option>Book</option>
<option>Watch</option>
<option>Keys</option>
<option>Others</option>

</select>

<label>Description</label>

<textarea
name="description"
placeholder="Describe the item..."
required></textarea>

<label>Lost Location</label>

<input
type="text"
name="location"
required>

<label>Upload Image</label>

<input
type="file"
name="image"
accept="image/*">

<button type="submit">
Submit Lost Report
</button>

</form>

<?php include("includes/footer.php"); ?>
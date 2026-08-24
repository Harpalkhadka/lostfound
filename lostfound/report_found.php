<?php
include("includes/auth.php");
?>

<!DOCTYPE html>
<html>
<head>
<title>Report Found Item</title>

<link rel="stylesheet"
href="assets/css/style.css">

</head>

<body>

<?php include("includes/sidebar.php"); ?>

<div class="main">

<?php include("includes/header.php"); ?>

<h2>Report Found Item</h2><br>

<form
action="save_item.php"
method="POST"
enctype="multipart/form-data"
class="item-form">

<input
type="hidden"
name="item_type"
value="found">

<label>Item Name</label>

<input
type="text"
name="item_name"
required>

<label>Category</label>

<select
name="category"
required>

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
required></textarea>

<label>Found Location</label>

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
Submit Found Report
</button>

</form>

<?php include("includes/footer.php"); ?>
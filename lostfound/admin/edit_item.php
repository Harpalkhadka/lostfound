<?php
include("../includes/auth.php");
include("../config/db.php");

if($_SESSION['role']!="admin"){
    header("Location:../dashboard.php");
    exit();
}

if(!isset($_GET['id'])){
    header("Location:manage_items.php");
    exit();
}

$id=(int)$_GET['id'];

$result=mysqli_query($conn,
"SELECT * FROM items WHERE id='$id'");

if(mysqli_num_rows($result)==0){
    header("Location:manage_items.php");
    exit();
}

$item=mysqli_fetch_assoc($result);

$message="";

if(isset($_POST['update'])){

    $item_name=mysqli_real_escape_string($conn,$_POST['item_name']);
    $category=mysqli_real_escape_string($conn,$_POST['category']);
    $description=mysqli_real_escape_string($conn,$_POST['description']);
    $location=mysqli_real_escape_string($conn,$_POST['location']);
    $item_type=mysqli_real_escape_string($conn,$_POST['item_type']);
    $status=mysqli_real_escape_string($conn,$_POST['status']);

    mysqli_query($conn,"
    UPDATE items SET

    item_name='$item_name',
    category='$category',
    description='$description',
    location='$location',
    item_type='$item_type',
    status='$status'

    WHERE id='$id'
    ");

    $message="Item Updated Successfully!";

    $result=mysqli_query($conn,
    "SELECT * FROM items WHERE id='$id'");

    $item=mysqli_fetch_assoc($result);

}
?>
<!DOCTYPE html>
<html>

<head>

<title>Edit Item</title>

<link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>

<?php include("sidebar.php"); ?>

<div class="main">

<?php include("../includes/header.php"); ?>

<h2>Edit Item</h2>

<?php
if($message!=""){
    echo "<p class='success'>$message</p>";
}
?>

<form method="POST" class="item-form">

<label>Item Name</label>

<input
type="text"
name="item_name"
value="<?php echo htmlspecialchars($item['item_name']); ?>"
required>

<label>Category</label>

<input
type="text"
name="category"
value="<?php echo htmlspecialchars($item['category']); ?>"
required>

<label>Description</label>

<textarea
name="description"
required><?php echo htmlspecialchars($item['description']); ?></textarea>

<label>Location</label>

<input
type="text"
name="location"
value="<?php echo htmlspecialchars($item['location']); ?>"
required>

<label>Item Type</label>

<select name="item_type">

<option value="lost"
<?php if($item['item_type']=="lost") echo "selected"; ?>>
Lost
</option>

<option value="found"
<?php if($item['item_type']=="found") echo "selected"; ?>>
Found
</option>

</select>

<label>Status</label>

<select name="status">

<option value="active"
<?php if($item['status']=="active") echo "selected"; ?>>
Active
</option>

<option value="recovered"
<?php if($item['status']=="recovered") echo "selected"; ?>>
Recovered
</option>

</select>

<br><br>

<button
type="submit"
name="update"
class="btn">

Update Item

</button>

<a
href="manage_items.php"
class="btn"
style="background:#6c757d; margin-left:10px;">

Cancel

</a>

</form>

<?php include("../includes/footer.php"); ?>
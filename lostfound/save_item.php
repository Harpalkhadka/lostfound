<?php

include("includes/auth.php");
include("config/db.php");

$user_id = $_SESSION['user_id'];

$item_name = mysqli_real_escape_string($conn,$_POST['item_name']);
$category = mysqli_real_escape_string($conn,$_POST['category']);
$description = mysqli_real_escape_string($conn,$_POST['description']);
$location = mysqli_real_escape_string($conn,$_POST['location']);
$item_type = $_POST['item_type'];

$image="";

if(isset($_FILES['image']) && $_FILES['image']['name']!="")
{

$filename=time()."_".basename($_FILES['image']['name']);

$target="assets/uploads/".$filename;

if(move_uploaded_file($_FILES['image']['tmp_name'],$target))
{
$image=$filename;
}

}

$sql="INSERT INTO items

(user_id,item_name,category,description,location,image,item_type)

VALUES

('$user_id',
'$item_name',
'$category',
'$description',
'$location',
'$image',
'$item_type')";

if(mysqli_query($conn,$sql))
{

header("Location: dashboard.php");
exit();

}
else
{

echo mysqli_error($conn);

}

?>
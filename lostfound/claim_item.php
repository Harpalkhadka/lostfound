<?php

include("includes/auth.php");
include("config/db.php");


// Check if item ID exists
if(!isset($_GET['id']))
{
    header("Location: browse.php");
    exit();
}


$item_id = (int)$_GET['id'];
$user_id = $_SESSION['user_id'];


// Get item
$query = mysqli_query($conn,
"SELECT * FROM items WHERE id='$item_id'");

$item = mysqli_fetch_assoc($query);


// Check if item exists
if(!$item)
{
    die("Item not found.");
}


// Prevent user from claiming their own item
if($item['user_id'] == $user_id)
{
    die("You cannot claim your own reported item.");
}


// Only FOUND items can be claimed
if($item['item_type'] != "found")
{
    die("Only found items can be claimed.");
}


// Only active items can be claimed
if($item['status'] != "active")
{
    die("This item is no longer available for claiming.");
}


$message = "";
$class = "msg";


// Submit Claim
if(isset($_POST['submit']))
{

    $phone = mysqli_real_escape_string(
        $conn,
        $_POST['phone']
    );

    $lost_location = mysqli_real_escape_string(
        $conn,
        $_POST['lost_location']
    );

    $lost_date = $_POST['lost_date'];

    $item_color = mysqli_real_escape_string(
        $conn,
        $_POST['item_color']
    );

    $brand = mysqli_real_escape_string(
        $conn,
        $_POST['brand']
    );

    $unique_marks = mysqli_real_escape_string(
        $conn,
        $_POST['unique_marks']
    );

    $items_inside = mysqli_real_escape_string(
        $conn,
        $_POST['items_inside']
    );

    $additional_details = mysqli_real_escape_string(
        $conn,
        $_POST['additional_details']
    );


    // Proof image
    $proof = "";


    if(
        isset($_FILES['proof_image']) &&
        $_FILES['proof_image']['name'] != ""
    )
    {

        $proof = time() . "_" .
        basename($_FILES['proof_image']['name']);


        move_uploaded_file(
            $_FILES['proof_image']['tmp_name'],
            "assets/uploads/" . $proof
        );

    }


    // Check if user already claimed this item
    $check = mysqli_query(
        $conn,
        "SELECT * FROM claims
        WHERE item_id='$item_id'
        AND user_id='$user_id'"
    );


    if(mysqli_num_rows($check) > 0)
    {

        $message = "You have already claimed this item.";
        $class = "msg";


    }
    else
    {

        $sql = "INSERT INTO claims
        (
            item_id,
            user_id,
            phone,
            lost_location,
            lost_date,
            item_color,
            brand,
            unique_marks,
            items_inside,
            proof_image,
            additional_details
        )

        VALUES
        (
            '$item_id',
            '$user_id',
            '$phone',
            '$lost_location',
            '$lost_date',
            '$item_color',
            '$brand',
            '$unique_marks',
            '$items_inside',
            '$proof',
            '$additional_details'
        )";


        if(mysqli_query($conn, $sql))
        {

            $message = "Claim submitted successfully.";
            $class = "msg success";

        }
        else
        {

            $message = "Error submitting claim.";
            $class = "msg";

        }

    }

}

?>

<!DOCTYPE html>

<html>

<head>

<title>Claim Item</title>

<link rel="stylesheet"
href="assets/css/style.css">

</head>


<body>


<?php include("includes/sidebar.php"); ?>


<div class="main">


<?php include("includes/header.php"); ?>


<h2>Ownership Verification Form</h2> <br>


<?php

if($message != "")
{

    echo "<p class='$class'>$message</p>";

}

?>


<div class="item-form">


<h3>
<?php echo htmlspecialchars($item['item_name']); ?>
</h3> <br><br>


<p>

<b>Category:</b> 

<?php
echo htmlspecialchars($item['category']);
?> <br><br>

</p>


<p>

<b>Description:</b> <br>

<?php
echo htmlspecialchars($item['description']);
?>

</p>


<form
method="POST"
enctype="multipart/form-data"
>


<label>Phone Number</label>

<input
type="text"
name="phone"
required
>


<label>Where did you lose it?</label>

<input
type="text"
name="lost_location"
required
>


<label>Approximate Lost Date</label>

<input
type="date"
name="lost_date"
required
>


<label>Item Color</label>

<input
type="text"
name="item_color"
required
>


<label>Brand</label>

<input
type="text"
name="brand"
>


<label>
Unique Marks / Stickers / Scratches
</label>

<textarea
name="unique_marks"
></textarea>


<label>
Items Inside (if applicable)
</label>

<textarea
name="items_inside"
></textarea>


<label>
Upload Proof (Optional)
</label>

<input
type="file"
name="proof_image"
accept="image/*"
>


<label>
Additional Information
</label>

<textarea
name="additional_details"
></textarea>


<button
type="submit"
name="submit"
>

Submit Claim

</button>


</form>


</div>


<?php include("includes/footer.php"); ?>


</div>


</body>

</html>
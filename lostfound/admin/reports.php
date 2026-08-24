<?php
include("auth.php");
include("../config/db.php");

if($_SESSION['role']!="admin"){
    header("Location:../dashboard.php");
    exit();
}

/* Users */
$totalUsers=mysqli_num_rows(mysqli_query($conn,"SELECT * FROM users"));
$totalStudents=mysqli_num_rows(mysqli_query($conn,"SELECT * FROM users WHERE role='student'"));
$totalTeachers=mysqli_num_rows(mysqli_query($conn,"SELECT * FROM users WHERE role='admin'"));

/* Items */
$totalItems=mysqli_num_rows(mysqli_query($conn,"SELECT * FROM items"));
$totalLost=mysqli_num_rows(mysqli_query($conn,"SELECT * FROM items WHERE item_type='lost'"));
$totalFound=mysqli_num_rows(mysqli_query($conn,"SELECT * FROM items WHERE item_type='found'"));
$totalRecovered=mysqli_num_rows(mysqli_query($conn,"SELECT * FROM items WHERE status='recovered'"));
$totalActive=mysqli_num_rows(mysqli_query($conn,"SELECT * FROM items WHERE status='active'"));

/* Claims */
$totalClaims=mysqli_num_rows(mysqli_query($conn,"SELECT * FROM claims"));
$totalPending=mysqli_num_rows(mysqli_query($conn,"SELECT * FROM claims WHERE claim_status='pending'"));
$totalApproved=mysqli_num_rows(mysqli_query($conn,"SELECT * FROM claims WHERE claim_status='approved'"));
$totalRejected=mysqli_num_rows(mysqli_query($conn,"SELECT * FROM claims WHERE claim_status='rejected'"));
?>

<!DOCTYPE html>
<html>

<head>

<title>Reports</title>

<link rel="stylesheet" href="../assets/css/style.css">

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body>

<div class="sidebar">

<h2>Admin Panel</h2>

<a href="dashboard.php"> Dashboard</a>

<a href="manage_users.php"> Manage Users</a>

<a href="manage_items.php"> Manage Items</a>

<a href="manage_claims.php"> Manage Claims</a>

<a href="reports.php"> Reports</a>

<a href="../logout.php"> Logout</a>

</div>

<div class="main">

<div class="topbar">

<h2>System Reports</h2>

</div>

<div class="cards">

<div class="card">
<h2>Total Users</h2>
<p><?php echo $totalUsers; ?></p>
</div>

<div class="card">
<h2>Students</h2>
<p><?php echo $totalStudents; ?></p>
</div>

<div class="card">
<h2>Teachers</h2>
<p><?php echo $totalTeachers; ?></p>
</div>

<div class="card">
<h2>Total Items</h2>
<p><?php echo $totalItems; ?></p>
</div>

<div class="card">
<h2>Lost</h2>
<p><?php echo $totalLost; ?></p>
</div>

<div class="card">
<h2>Found</h2>
<p><?php echo $totalFound; ?></p>
</div>

<div class="card">
<h2>Recovered</h2>
<p><?php echo $totalRecovered; ?></p>
</div>

<div class="card">
<h2>Active</h2>
<p><?php echo $totalActive; ?></p>
</div>

<div class="card">
<h2>Claims</h2>
<p><?php echo $totalClaims; ?></p>
</div>

<div class="card">
<h2>Pending</h2>
<p><?php echo $totalPending; ?></p>
</div>

<div class="card">
<h2>Approved</h2>
<p><?php echo $totalApproved; ?></p>
</div>

<div class="card">
<h2>Rejected</h2>
<p><?php echo $totalRejected; ?></p>
</div>

</div>

<br><br>

<canvas id="itemChart" height="100"></canvas>

<br><br>

<canvas id="claimChart" height="100"></canvas>

</div>

<script>

const itemChart=new Chart(document.getElementById('itemChart'),{

type:'bar',

data:{

labels:['Lost','Found','Recovered'],

datasets:[{

label:'Items',

data:[
<?php echo $totalLost;?>,
<?php echo $totalFound;?>,
<?php echo $totalRecovered;?>
]

}]

}

});

const claimChart=new Chart(document.getElementById('claimChart'),{

type:'pie',

data:{

labels:['Pending','Approved','Rejected'],

datasets:[{

data:[
<?php echo $totalPending;?>,
<?php echo $totalApproved;?>,
<?php echo $totalRejected;?>
]

}]

}

});

<?php include("../includes/footer.php"); ?>
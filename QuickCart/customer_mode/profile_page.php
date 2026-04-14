<?php
include ('../functions/common_function.php');

if (isset($_GET['customer_id'])) {
    $cust_id = $_GET['customer_id'];
    $get_data = "SELECT * FROM customer WHERE customerID = $cust_id;";
    $result_get = mysqli_query($con, $get_data);
    $row_data = mysqli_fetch_assoc($result_get);
    $cust_id    = $row_data["customerID"];
    $cust_fname = $row_data['first_name'];
    $cust_lname = $row_data['last_name'];
    $pass       = $row_data['password'];
    $email      = $row_data['email'];
    $phone      = $row_data['phone_no'];
    $street     = $row_data['address_street'];
    $city       = $row_data['address_city'];
    $state      = $row_data['address_state'];
    $pincode    = $row_data['pincode'];
    $dob        = $row_data['dob'];
    $gender     = $row_data['gender'];
    $cust_name  = $cust_lname ? "$cust_fname $cust_lname" : $cust_fname;
    $cust_address = "$street, $city, $state, Pincode - $pincode";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile – ShopEase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../style.css">
    <style>
        body { background: #F7F2EB; overflow-x: hidden; }
    </style>
</head>
<body>

    <?php include('../includes/customer_topnav.php'); ?>

    <div class="container my-4">

        <?php if (isset($_GET['view_profile'])): ?>
            <?php include('view_profile.php'); ?>
        <?php elseif (isset($_GET['edit_profile'])): ?>
            <?php include('edit_profile.php'); ?>
        <?php elseif (isset($_GET['view_orders'])): ?>
            <?php include('view_orders.php'); ?>
        <?php elseif (isset($_GET['top_up'])): ?>
            <?php include('top_up.php'); ?>
        <?php elseif (isset($_GET['rate_order'])): ?>
            <?php include('rate_order.php'); ?>
        <?php elseif (isset($_GET['give_oreview'])): ?>
            <?php include('give_oreview.php'); ?>
        <?php elseif (isset($_GET['rate_delivery'])): ?>
            <?php include('rate_delivery.php'); ?>
        <?php elseif (isset($_GET['give_dreview'])): ?>
            <?php include('give_dreview.php'); ?>
        <?php else: ?>
            <?php include('view_profile.php'); ?>
        <?php endif; ?>

    </div>

    <?php include('../includes/footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

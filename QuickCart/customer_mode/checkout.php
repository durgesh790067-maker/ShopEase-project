<?php
include ('../functions/common_function.php');
include ('busystatus_trigger.php');

if (isset($_GET['customer_id'])) {
    $cust_id = $_GET['customer_id'];
    $get_data = "SELECT * FROM customer WHERE customerID = $cust_id;";
    $result_get = mysqli_query($con, $get_data);
    $row_data = mysqli_fetch_assoc($result_get);
    $cust_id    = $row_data["customerID"];
    $cust_fname = $row_data['first_name'];
    $cust_lname = $row_data['last_name'];
    $street     = $row_data['address_street'];
    $city       = $row_data['address_city'];
    $state      = $row_data['address_state'];
    $pincode    = $row_data['pincode'];
    $cust_name  = $cust_lname ? "$cust_fname $cust_lname" : $cust_fname;
    $totalPrice  = total_cart($cust_id);
    $total_items = cart_total_item($cust_id);
    $cust_address = "$street, $city, $state, Pincode - $pincode";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout – ShopEase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../style.css">
    <style>
        body { background: #F7F2EB; overflow-x: hidden; }
        .checkout-card {
            background: #FFFFFF; border: 1px solid #FFE6CD;
            border-radius: 16px; padding: 28px;
            box-shadow: 0 4px 18px rgba(0,0,0,0.07);
        }
    </style>
</head>
<body>

    <?php include('../includes/customer_topnav.php'); ?>

    <div class="container my-4" style="max-width:760px;">
        <div class="checkout-card">
            <h2 class="text-center mb-1"><i class="fas fa-receipt me-2" style="color:#FFE6CD;"></i>Order Summary</h2>
            <div class="title-divider mb-4"></div>

            <table class="table table-bordered mt-2">
                <thead>
                    <tr>
                        <th style="background:#FFE6CD;color:#1A1A1A;">#</th>
                        <th style="background:#FFE6CD;color:#1A1A1A;">Item</th>
                        <th style="background:#FFE6CD;color:#1A1A1A;">Qty</th>
                        <th style="background:#FFE6CD;color:#1A1A1A;">Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $get_cart = "SELECT * FROM addsToCart WHERE customerID = '$cust_id';";
                    $result_get = mysqli_query($con, $get_cart);
                    $number = 0;
                    while ($row_get = mysqli_fetch_assoc($result_get)) {
                        $prodID = $row_get["productID"];
                        $q = $row_get["quantity"];
                        $get_prod = "SELECT * FROM product WHERE productID = '$prodID';";
                        $result_prod = mysqli_query($con, $get_prod);
                        $row_prod = mysqli_fetch_assoc($result_prod);
                        $prod_name = $row_prod["name"];
                        $prod_price = $row_prod["price"];
                        $number++;
                    ?>
                    <tr>
                        <td><?php echo $number; ?></td>
                        <td><?php echo $prod_name; ?></td>
                        <td><?php echo $q; ?></td>
                        <td>₹<?php echo $prod_price; ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>

            <div class="d-flex justify-content-between align-items-center mt-3 px-1">
                <span style="font-size:1rem;color:#888;">Grand Total</span>
                <strong style="font-size:1.2rem;color:#1A1A1A;">₹<?php echo $totalPrice; ?></strong>
            </div>

            <hr style="border-color:#FFE6CD;margin:16px 0;">

            <h5><i class="fas fa-map-marker-alt me-1" style="color:#FFE6CD;"></i>Delivery Address</h5>
            <p class="text-muted"><?php echo $cust_address; ?></p>

            <div class="d-flex gap-2 mt-3">
                <form action="place_order.php?customer_id=<?php echo $cust_id; ?>" method="post">
                    <button type="submit" name="confirm_order" class="app-nav-btn" style="background:#1A1A1A;color:#fff;border:none;">
                        <i class="fas fa-check-circle"></i> Confirm & Place Order
                    </button>
                </form>
                <a href="index.php?customer_id=<?php echo $cust_id; ?>" class="app-nav-btn">
                    <i class="fas fa-arrow-left"></i> Go Back
                </a>
            </div>
        </div>
    </div>

    <?php include('../includes/footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

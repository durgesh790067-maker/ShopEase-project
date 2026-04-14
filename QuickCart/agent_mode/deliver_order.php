<?php
include('../includes/connect.php');

if (isset($_GET['agent_id']) and isset($_GET['order_id'])) {
    $agent_id = $_GET['agent_id'];
    $order_id = $_GET['order_id'];

    $order_query = "SELECT * FROM `order` WHERE status = 'Packed and Shipped' AND orderID = '$order_id';";
    $order_result = mysqli_query($con, $order_query);
    $row = mysqli_fetch_assoc($order_result);
    $order_id = $row['orderID'];
    $order_location = $row['location'];
    $order_price = $row['total_price'];
    $order_time = $row['time'];
    $order_custID = $row['customerID'];
    $order_agentID = $row['agentID'];
    $order_status = $row['status'];
    $order_agentPayment = $row['agentPayment'];

    $get_cust = "SELECT * FROM customer WHERE customerID = $order_custID;";
    $result_get = mysqli_query($con, $get_cust);
    $row_cust = mysqli_fetch_assoc($result_get);
    $cust_fname = $row_cust['first_name'];
    $cust_lname = $row_cust['last_name'];
    if ($cust_lname === null) {
        $cust_name = $cust_fname;
    } else {
        $cust_name = $cust_fname . ' ' . $cust_lname;
    }

    $get_Dwallet = "SELECT * FROM delivery_agent_wallet WHERE agentID = '$agent_id';";
    $result_Dwallet = mysqli_query($con, $get_Dwallet);
    $row_Dwallet = mysqli_fetch_assoc($result_Dwallet);
    $balance = $row_Dwallet["earning_balance"];
    $withdrawn = $row_Dwallet["earning_paid"];
    $total = $row_Dwallet["earning_total"];
    $transaction = $row_Dwallet["Transaction_history"];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deliver Order</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg bg-pastel">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><i class="fa fa-shopping-basket" aria-hidden="true"> ShopEase</i></a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" href="index.php?agent_id=<?php echo $agent_id; ?>&home">← Back to Home</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-3">
    <h2 class="text-center">Deliver Order</h2>
    <h5 class="w-50 m-auto my-4"> Order ID:
        <?php echo "$order_id"; ?>
    </h5>
    <h5 class="w-50 m-auto my-4"> Customer Name:
        <?php echo "$cust_name"; ?>
    </h5>
    <h5 class="w-50 m-auto my-4"> Delivered to Address:
        <?php echo "$order_location"; ?>
    </h5>
    <h5 class="w-50 m-auto my-4"> Order Placed on:
        <?php echo "$order_time"; ?>
    </h5>
    <h5 class="w-50 m-auto my-4"> Your Earning:
        <?php echo "₹$order_agentPayment"; ?>
    </h5>

    <form action="" method="post">
        <input type="hidden" name="hidden_agent_id" value="<?php echo $agent_id; ?>">
        <input type="hidden" name="hidden_order_id" value="<?php echo $order_id; ?>">
        <input type="hidden" name="hidden_order_agentPayment" value="<?php echo $order_agentPayment; ?>">
        <div class="form-outline mb-4 w-50 m-auto">
            <input type="submit" name="submit_deliver" class="btn btn-pastel mb-3 px-3" value="Deliver Order">
        </div>
    </form>
</div>

<!-- updating order's details in the database -->
<?php
if (isset($_POST['submit_deliver'])) {
    $agent_id = $_POST['hidden_agent_id'];
    $order_id = $_POST['hidden_order_id'];
    $order_agentPayment = $_POST['hidden_order_agentPayment'];

    // Re-fetch wallet data for up-to-date values
    $get_Dwallet2 = "SELECT * FROM delivery_agent_wallet WHERE agentID = '$agent_id';";
    $result_Dwallet2 = mysqli_query($con, $get_Dwallet2);
    $row_Dwallet2 = mysqli_fetch_assoc($result_Dwallet2);
    $balance = $row_Dwallet2["earning_balance"];
    $withdrawn = $row_Dwallet2["earning_paid"];
    $total = $row_Dwallet2["earning_total"];
    $transaction = $row_Dwallet2["Transaction_history"];

    $safe_mode_query = "SET SQL_SAFE_UPDATES = 0;";
    mysqli_query($con, $safe_mode_query);

    $update_agentStatus = "UPDATE deliveryAgent SET availabilityStatus = 'Available' WHERE agentID = '$agent_id';";
    mysqli_query($con, $update_agentStatus);

    $new_balance = $balance + $order_agentPayment;
    $new_balance1 = number_format($new_balance, 2);
    $new_total = $total + $order_agentPayment;
    $new_total1 = number_format($new_total, 2);

    $current_date = date("d-m-Y");

    $trans_statement = "$current_date^ You earned ₹$order_agentPayment for successfully delivering order $order_id^ $new_balance1^ $withdrawn^ $new_total1";
    $new_Trans = $transaction . "| " . $trans_statement;

    $update_Dwallet = "UPDATE delivery_agent_wallet SET earning_balance = $new_balance, earning_total = $new_total, Transaction_history = '$new_Trans' WHERE agentID = '$agent_id';";
    $result_Dwallet = mysqli_query($con, $update_Dwallet);

    $update_order = "UPDATE `order` SET status = 'Delivered' WHERE orderID = '$order_id';";
    $result_update = mysqli_query($con, $update_order);

    if ($result_update && $result_Dwallet) {
        echo "<script>alert('Order has been delivered successfully.'); window.location.href = 'index.php?agent_id=" . $agent_id . "&home';</script>";
    } else {
        echo "<script>alert('Error updating order. Please try again.');</script>";
    }
}
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>
</html>

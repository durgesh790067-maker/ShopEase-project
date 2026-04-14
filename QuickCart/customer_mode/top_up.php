<?php
if (basename(__FILE__) === basename($_SERVER['PHP_SELF'])) {
    if (isset($_GET['customer_id'])) {
        header("Location: profile_page.php?customer_id=" . intval($_GET['customer_id']) . "&top_up");
    } else {
        header("Location: customer_login.php");
    }
    exit;
}
if (!isset($con)) { include_once('../includes/connect.php'); }
if (!isset($cust_id)) {
    if (isset($_GET['customer_id'])) {
        $cust_id = intval($_GET['customer_id']);
    } else {
        header('Location: customer_login.php');
        exit;
    }
}
if (!isset($cust_name)) {
    $r = mysqli_query($con, "SELECT first_name, last_name FROM customer WHERE customerID = $cust_id");
    $row = mysqli_fetch_assoc($r);
    $cust_name = trim(($row['first_name'] ?? '') . ' ' . ($row['last_name'] ?? ''));
}
    $get_data = "SELECT * FROM wallet WHERE customerID = $cust_id;";
    $result_get = mysqli_query($con, $get_data);
    $row_data = mysqli_fetch_assoc($result_get);
    $balance = $row_data["balance"];
    $upiID = $row_data["upiID"];
    $rewardPoints = $row_data["rewardPoints"];
?>

<div class="container mt-3">
    <h2 class="text-center">Top Up Wallet</h2>
    <h4 class="w-50 m-auto my-4">Current Balance: ₹<?php echo "$balance";?></h4>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="form-outline mb-4 w-50 m-auto">
            <label for="amount" class="form-label">Top Up Ammount</label>
            <input type="number" name="amount" id="amount" value="<?php echo "$amount"; ?>"
                class="form-control" placeholder="Enter Amount" autocomplete="off" required="required" min="0">
        </div>
        <div class="form-outline mb-4 w-50 m-auto">
                        <!-- password field -->
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" class="form-control" placeholder="Enter your Password"
                        autocomplete="off" required="required" name="password" />
                    </div>
        <div class="form-outline mb-4 w-50 m-auto">
            <input type="submit" name="edit_amount" class="btn btn-pastel mb-3 px-3" value="Top Up">
        </div>
    </form>
</div>

<!-- updating wallet's details in the database -->
<?php
if (isset ($_POST['edit_amount'])) {
    $added_amount = $_POST['amount'];
    $password = $_POST['password'];

    if ($added_amount == '') {
        echo "<script> alert('Please fill all the available fields.')</script>";
        exit();
    } else if ($password != $pass){
        echo "<script> alert('Incorrect Password. Please try again.')</script>";
    }
    else {
        $safe_mode_query = "SET SQL_SAFE_UPDATES = 0;";
        $result_safe = mysqli_query($con, $safe_mode_query);
        if ($result_safe==0){
            echo "Couldn't turn safe mode OFF";
        }
        $new_amount = $balance + $added_amount;
        $update_query = "UPDATE wallet SET balance = '$new_amount' WHERE customerID = '$cust_id';";
        $result_query = mysqli_query($con, $update_query);
        if ($result_query) {
            echo "<script>alert('Wallet Balance has been updated successfully. Updated balance = ₹$new_amount'); window.location.href = 'profile_page.php?customer_id=" . $cust_id . "&top_up';</script>";
        }
    }
}
?>

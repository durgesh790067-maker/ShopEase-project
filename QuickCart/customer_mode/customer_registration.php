<?php
include ('../includes/connect.php');
include ('age_trigger.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register – ShopEase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../style.css">
    <style>
        body {
            background: linear-gradient(135deg, #fdf6f0 0%, #f9e8e8 50%, #fdf0f5 100%);
            padding: 40px 15px;
        }
        .reg-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 8px 40px rgba(180,120,120,0.15);
            padding: 40px;
            border: 1px solid #f0d5d5;
            max-width: 560px;
            margin: 0 auto;
        }
        .reg-title {
            font-family: 'Playfair Display', serif;
            color: #7d4a4a;
            font-size: 1.8rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 4px;
        }
        .reg-sub {
            text-align: center;
            color: #b58585;
            font-size: 0.88rem;
            margin-bottom: 28px;
        }
        .section-divider {
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #c97b7b;
            border-bottom: 1px solid #f0d5d5;
            padding-bottom: 6px;
            margin: 20px 0 16px;
            font-weight: 700;
        }
        .back-link { color: #b58585; font-size: 0.88rem; text-decoration: none; display: inline-block; margin-bottom: 16px; }
        .back-link:hover { color: #c97b7b; }
    </style>
</head>
<body>
    <div style="max-width:560px; margin:0 auto;">
        <?php $pending_product = isset($_GET['pending_product']) ? intval($_GET['pending_product']) : 0; ?>
        <a href="customer_login.php<?php echo $pending_product > 0 ? '?pending_product='.$pending_product : ''; ?>" class="back-link"><i class="fas fa-arrow-left me-1"></i> Back to Login</a>
    </div>
    <div class="reg-card">
        <div class="text-center mb-2" style="font-size:2rem; color:#c97b7b;"><i class="fas fa-user-plus"></i></div>
        <h2 class="reg-title">Create Account</h2>
        <p class="reg-sub">Join ShopEase — it's free!</p>
        <form action="" method="post">
            <input type="hidden" name="pending_product" value="<?php echo $pending_product; ?>">
            <div class="section-divider">Personal Information</div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">First Name</label>
                    <input type="text" class="form-control" placeholder="First name" autocomplete="off" required name="first_name"/>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Last Name</label>
                    <input type="text" class="form-control" placeholder="Last name" autocomplete="off" name="last_name"/>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Date of Birth</label>
                    <input type="text" class="form-control" pattern="\d{4}-\d{2}-\d{2}" placeholder="YYYY-MM-DD" autocomplete="off" required name="dob"/>
                    <small class="text-muted">Format: YYYY-MM-DD</small>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Gender</label>
                    <select class="form-select" required name="gender">
                        <option value="" disabled selected>Select gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Phone Number</label>
                <input type="number" class="form-control" placeholder="10-digit phone number" autocomplete="off" required name="phone_no" min="0"/>
            </div>

            <div class="section-divider">Address</div>
            <div class="mb-3">
                <label class="form-label">Street Address</label>
                <input type="text" class="form-control" placeholder="Street address" autocomplete="off" required name="address_street"/>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">City</label>
                    <input type="text" class="form-control" placeholder="City" autocomplete="off" required name="address_city"/>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">State</label>
                    <input type="text" class="form-control" placeholder="State" autocomplete="off" required name="address_state"/>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Pincode</label>
                    <input type="number" class="form-control" placeholder="Pincode" autocomplete="off" required name="pincode" min="0"/>
                </div>
            </div>

            <div class="section-divider">Account Details</div>
            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="text" class="form-control" placeholder="Your email address" autocomplete="off" required name="email"/>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" placeholder="Create password" autocomplete="off" required name="password"/>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" placeholder="Confirm password" autocomplete="off" required name="conf_customer_password"/>
                </div>
            </div>

            <input type="submit" value="Create Account" class="btn btn-pastel w-100 mt-2" name="customer_register">
            <p class="text-center mt-3 mb-0" style="font-size:0.88rem; color:#b58585;">
                Already have an account?
                <a href="customer_login.php<?php echo $pending_product > 0 ? '?pending_product='.$pending_product : ''; ?>" style="color:#c97b7b; font-weight:600;"> Sign in</a>
            </p>
        </form>
    </div>
</body>
</html>
<?php
if (isset($_POST['customer_register'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $address_street = $_POST['address_street'];
    $address_city = $_POST['address_city'];
    $address_state = $_POST['address_state'];
    $pincode = $_POST['pincode'];
    $phone_no = $_POST['phone_no'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $conf_password = $_POST['conf_customer_password'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $pending = isset($_POST['pending_product']) ? intval($_POST['pending_product']) : 0;

    $select_total = "SELECT * FROM customer;";
    $result_total = mysqli_query($con, $select_total);
    $row_total = mysqli_num_rows($result_total);
    $select_query = "SELECT * FROM customer WHERE email='$email' OR phone_no='$phone_no';";
    $result = mysqli_query($con, $select_query);
    $rows_count = mysqli_num_rows($result);
    if ($rows_count > 0) {
        echo "<script>alert('Customer with given Email or Phone Number already exists. Please login.')</script>";
    } else if ($password != $conf_password) {
        echo "<script>alert('Passwords do not match. Please try again.')</script>";
    } else {
        $insert_query = "INSERT INTO customer (first_name, last_name, address_street, address_city, address_state, pincode, phone_no, email, password, dob, age, gender) values ('$first_name','$last_name','$address_street','$address_city','$address_state','$pincode','$phone_no','$email','$password','$dob',DEFAULT,'$gender');";
        $sql_execute = mysqli_query($con, $insert_query);
        $safe_mode_query = "SET SQL_SAFE_UPDATES = 0;";
        mysqli_query($con, $safe_mode_query);
        $update_customers = "UPDATE Customer SET age = DATEDIFF(CURDATE(), dob) / 365;";
        mysqli_query($con, $update_customers);
        $new_cust = $row_total + 1;
        $upi_id = 'customer' . $new_cust . '@upi';
        $insert_wallet = "INSERT INTO wallet (customerID, balance, upiID, rewardPoints) VALUES ('$new_cust', DEFAULT, '$upi_id', DEFAULT);";
        $sql_wallet = mysqli_query($con, $insert_wallet);
        if ($sql_execute && $sql_wallet) {
            $login_redirect = 'customer_login.php' . ($pending > 0 ? '?pending_product=' . $pending : '');
            echo "<script>alert('Registered successfully! Please login.'); window.location.href = '$login_redirect';</script>";
        } else {
            die(mysqli_error($con));
        }
    }
}
?>

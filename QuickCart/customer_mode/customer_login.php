<?php include ('../includes/connect.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Login – ShopEase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../style.css">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #EEECF1 0%, #dce8f3 50%, #EEECF1 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 15px;
        }
        .auth-wrap { width: 100%; max-width: 440px; }
        .back-link { color: #949494; font-size: 0.88rem; text-decoration: none; display: inline-block; margin-bottom: 20px; }
        .back-link:hover { color: #759CC9; }
    </style>
</head>
<body>
    <div class="auth-wrap">
        <a href="../start.php" class="back-link"><i class="fas fa-arrow-left me-1"></i> Back to Home</a>
        <div class="auth-card text-center">
            <div class="brand-icon"><i class="fas fa-user-circle"></i></div>
            <h2 class="auth-title">Welcome Back</h2>
            <p class="auth-subtitle">Sign in to your ShopEase account</p>
            <form action="" method="post">
                <div class="mb-3 text-start">
                    <label class="form-label"><i class="fas fa-envelope me-1"></i> Email Address</label>
                    <input type="text" class="form-control" placeholder="Enter your email" autocomplete="off" required name="email"/>
                </div>
                <div class="mb-4 text-start">
                    <label class="form-label"><i class="fas fa-lock me-1"></i> Password</label>
                    <input type="password" class="form-control" placeholder="Enter your password" autocomplete="off" required name="password"/>
                </div>
                <input type="submit" value="Sign In" class="btn btn-pastel w-100 mb-3" name="user_login">
                <p class="mb-0" style="font-size:0.88rem; color:#949494;">
                    Don't have an account?
                    <a href="customer_registration.php" style="color:#759CC9; font-weight:600;"> Register here</a>
                </p>
            </form>
        </div>
    </div>
</body>
</html>
<?php
if (isset($_POST['user_login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $select_query = "SELECT * FROM customer WHERE email='$email' AND password='$password';";
    $result = mysqli_query($con, $select_query);
    $rows_count = mysqli_num_rows($result);
    if ($rows_count > 0) {
        $row_data = mysqli_fetch_assoc($result);
        $customer_id = $row_data["customerID"];
        echo "<script>alert('Logged In successfully'); window.location.href = 'index.php?customer_id=" . $customer_id . "';</script>";
    } else {
        echo "<script>alert('Invalid Credentials')</script>";
    }
}
?>

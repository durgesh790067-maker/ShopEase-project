<?php include ('../includes/connect.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login – ShopEase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../style.css">
    <style>
        body {
            min-height: 100vh;
            background: #F7F2EB;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 15px;
        }
        .auth-wrap { width: 100%; max-width: 440px; }
        .back-link { color: #888; font-size: 0.88rem; text-decoration: none; display: inline-block; margin-bottom: 20px; }
        .back-link:hover { color: #1A1A1A; }
    </style>
</head>
<body>
    <div class="auth-wrap">
        <a href="../start.php" class="back-link"><i class="fas fa-arrow-left me-1"></i> Back to Home</a>
        <div class="auth-card text-center">
            <div class="brand-icon"><i class="fas fa-user-shield"></i></div>
            <h2 class="auth-title">Admin Portal</h2>
            <p class="auth-subtitle">Enter your admin password to continue</p>
            <form action="" method="post">
                <div class="mb-4 text-start">
                    <label class="form-label"><i class="fas fa-lock me-1"></i> Admin Password</label>
                    <input type="password" class="form-control" placeholder="Enter admin password" autocomplete="off" required name="password"/>
                </div>
                <input type="submit" value="Sign In" class="btn btn-pastel w-100" name="admin_login">
            </form>
        </div>
    </div>
</body>
</html>
<?php
if (isset($_POST['admin_login'])) {
    $password = $_POST['password'];
    $select_query = "SELECT * FROM admin WHERE password='$password';";
    $result = mysqli_query($con, $select_query);
    $rows_count = mysqli_num_rows($result);
    if ($rows_count > 0) {
        $row_data = mysqli_fetch_assoc($result);
        $admin_id = $row_data["adminID"];
        echo "<script>alert('Logged In successfully'); window.location.href = 'index.php?admin_id=" . $admin_id . "&home';</script>";
    } else {
        echo "<script>alert('Invalid Credentials')</script>";
    }
}
?>

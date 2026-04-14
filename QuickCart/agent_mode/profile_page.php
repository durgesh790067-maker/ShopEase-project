<?php
include ('../includes/connect.php');

if (isset($_GET['agent_id'])) {
    $agent_id = $_GET['agent_id'];
    $get_data = "SELECT * FROM deliveryAgent WHERE agentID = $agent_id;";
    $result_get = mysqli_query($con, $get_data);
    $row_data   = mysqli_fetch_assoc($result_get);
    $agent_id     = $row_data["agentID"];
    $agent_fname  = $row_data['first_name'];
    $agent_lname  = $row_data['last_name'];
    $pass         = $row_data['password'];
    $email        = $row_data['email'];
    $phone        = $row_data['phone_no'];
    $dob          = $row_data['dob'];
    $age          = $row_data['age'];
    $agent_status = $row_data['availabilityStatus'];
    $agent_name   = $agent_lname ? "$agent_fname $agent_lname" : $agent_fname;

    $get_wallet = "SELECT * FROM delivery_agent_wallet WHERE agentID = $agent_id;";
    $result_wallet = mysqli_query($con, $get_wallet);
    $row_wallet      = mysqli_fetch_assoc($result_wallet);
    $earning_balance = $row_wallet["earning_balance"];
    $earning_paid    = $row_wallet["earning_paid"];
    $earning_total   = $row_wallet["earning_total"];

    $nextPage = ($agent_status == "Offline") ? "offlineHome" : "home";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile – ShopEase Agent</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../style.css">
    <style>
        body { background: #F7F2EB; overflow-x: hidden; }
    </style>
</head>
<body>

    <!-- Agent Top Bar -->
    <div class="app-topbar">
        <a href="index.php?agent_id=<?php echo $agent_id . '&' . $nextPage; ?>" class="brand">
            <i class="fas fa-truck"></i> ShopEase Agent
        </a>
        <div class="topbar-right">
            <span class="welcome-text"><i class="fas fa-user-circle me-1"></i>Welcome, <strong><?php echo $agent_name; ?></strong></span>
        </div>
    </div>

    <!-- Agent Action Nav -->
    <div class="app-action-nav">
        <a href="profile_page.php?agent_id=<?php echo $agent_id; ?>&view_profile" class="app-nav-btn">
            <i class="fas fa-user"></i> View Profile
        </a>
        <a href="profile_page.php?agent_id=<?php echo $agent_id; ?>&wallet_history" class="app-nav-btn">
            <i class="fas fa-wallet"></i> Wallet History
        </a>
        <a href="profile_page.php?agent_id=<?php echo $agent_id; ?>&top_up" class="app-nav-btn">
            <i class="fas fa-money-bill-wave"></i> Withdraw Money
        </a>
        <a href="profile_page.php?agent_id=<?php echo $agent_id; ?>&history" class="app-nav-btn">
            <i class="fas fa-history"></i> Delivery History
        </a>
        <a href="profile_page.php?agent_id=<?php echo $agent_id; ?>&view_reviews" class="app-nav-btn">
            <i class="fas fa-star"></i> My Reviews
        </a>
        <a href="index.php?agent_id=<?php echo $agent_id . '&' . $nextPage; ?>" class="app-nav-btn">
            <i class="fas fa-home"></i> Home
        </a>
        <a href="../start.php" class="app-nav-btn logout-btn">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </div>

    <div class="container my-4">
        <?php
        if (isset($_GET['view_profile']))   include('view_profile.php');
        elseif (isset($_GET['edit_profile'])) include('edit_profile.php');
        elseif (isset($_GET['history']))     include('agent_history.php');
        elseif (isset($_GET['top_up']))      include('top_up.php');
        elseif (isset($_GET['wallet_history'])) include('wallet_history.php');
        elseif (isset($_GET['view_reviews'])) include('agent_reviews.php');
        else include('view_profile.php');
        ?>
    </div>

    <?php include('../includes/footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

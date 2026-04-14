<?php
include ('../functions/common_function.php');

if (isset ($_GET['agent_id'])) {
    $agent_id = $_GET['agent_id'];
    $get_data = "SELECT * FROM deliveryAgent WHERE agentID = $agent_id;";
    $result_get = mysqli_query($con, $get_data);
    $row_data = mysqli_fetch_assoc($result_get);
    $agent_fname = $row_data['first_name'];
    $agent_lname = $row_data['last_name'];
    $current_status = $row_data['availabilityStatus'];
    if ($agent_lname === null) {
        $agent_name = $agent_fname;
    } else {
        $agent_name = $agent_fname . ' ' . $agent_lname;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agent Mode – ShopEase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../style.css">
    <style>
        body { overflow-x: hidden; background: #EEECF1; }

        /* ── top navbar ── */
        .agent-topbar {
            background: linear-gradient(90deg, #759CC9 0%, #8FB1CC 100%);
            border-bottom: 1px solid #5a85b5;
            padding: 12px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 8px rgba(90,133,181,0.18);
        }
        .agent-topbar .brand {
            font-family: 'Playfair Display', serif;
            font-size: 1.25rem;
            font-weight: 700;
            color: #fff;
            text-decoration: none;
        }
        .agent-topbar .brand i { margin-right: 6px; }
        .agent-topbar .topbar-right {
            display: flex;
            align-items: center;
            gap: 16px;
            font-size: 0.88rem;
        }
        .agent-topbar a {
            color: #fff;
            text-decoration: none;
            font-weight: 600;
        }
        .agent-topbar a:hover { color: #EEECF1; }
        .agent-topbar .welcome-text { color: #EEECF1; }

        /* ── status bar ── */
        .agent-status-bar {
            background: #fff;
            border-bottom: 1px solid #ADC3D1;
            padding: 10px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
        }
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 14px;
            border-radius: 20px;
            font-size: 0.82rem;
            font-weight: 600;
        }
        .status-available { background: #dce8f3; color: #3a6a9c; border: 1px solid #ADC3D1; }
        .status-offline   { background: #EEECF1; color: #949494; border: 1px solid #AEAEAE; }
        .status-busy      { background: #f5f8fc; color: #759CC9; border: 1px solid #8FB1CC; }

        .agent-action-nav {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            align-items: center;
        }
        .agent-nav-btn {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 14px;
            border-radius: 20px;
            font-size: 0.81rem;
            font-weight: 600;
            color: #3a4a5c;
            background: #EEECF1;
            border: 1.5px solid #ADC3D1;
            text-decoration: none;
            transition: all 0.2s;
            white-space: nowrap;
        }
        .agent-nav-btn i { color: #759CC9; font-size: 0.78rem; }
        .agent-nav-btn:hover {
            background: #dce8f3;
            border-color: #759CC9;
            color: #759CC9;
            transform: translateY(-1px);
            box-shadow: 0 3px 10px rgba(90,133,181,0.15);
        }
        .agent-nav-btn.logout-btn {
            background: #f5f8fc;
            border-color: #AEAEAE;
            color: #949494;
        }
        .agent-nav-btn.logout-btn i { color: #AEAEAE; }
        .agent-nav-btn.logout-btn:hover {
            background: #EEECF1;
            border-color: #759CC9;
            color: #759CC9;
        }
        .agent-nav-btn.logout-btn:hover i { color: #759CC9; }

        /* dropdown menu */
        .dropdown-item.active, .dropdown-item:active {
            background-color: #dce8f3;
            color: #759CC9;
        }
    </style>
</head>

<body>

<div class="container-fluid p-0">

    <!-- Top bar -->
    <div class="agent-topbar">
        <a href="index.php?agent_id=<?php echo $agent_id; ?>&home" class="brand">
            <i class="fas fa-truck"></i> ShopEase
        </a>
        <div class="topbar-right">
            <span class="welcome-text"><i class="fas fa-user-circle me-1"></i>Welcome, <strong><?php echo $agent_name; ?></strong></span>
        </div>
    </div>

    <!-- Status + Action Bar -->
    <div class="agent-status-bar">
        <div class="d-flex align-items-center gap-2">
            <span class="me-1" style="font-size:0.82rem;color:#3a4a5c;font-weight:600;">Status:</span>
            <?php
            $statusClass = 'status-available';
            if ($current_status === 'Offline') $statusClass = 'status-offline';
            elseif ($current_status === 'Busy') $statusClass = 'status-busy';
            ?>
            <span class="status-badge <?php echo $statusClass; ?>">
                <i class="fas fa-circle" style="font-size:0.5rem;"></i>
                <?php echo $current_status; ?>
            </span>

            <!-- Set Status Dropdown -->
            <div class="dropdown">
                <button class="agent-nav-btn dropdown-toggle" data-bs-toggle="dropdown" style="border:none;cursor:pointer;">
                    <i class="fas fa-exchange-alt"></i> Set Status
                </button>
                <ul class="dropdown-menu">
                    <?php if ($current_status === 'Busy') { ?>
                        <li><span class="dropdown-item text-muted" style="font-size:0.82rem;">Complete current delivery first.</span></li>
                    <?php } else { ?>
                        <li>
                            <a class="dropdown-item <?php echo $current_status === 'Available' ? 'active' : ''; ?>"
                                href="index.php?agent_id=<?php echo $agent_id; ?>&home">
                                <i class="fas fa-check-circle me-1" style="color:#759CC9;"></i>Available
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item <?php echo $current_status === 'Offline' ? 'active' : ''; ?>"
                                href="index.php?agent_id=<?php echo $agent_id; ?>&takeToOffline">
                                <i class="fas fa-moon me-1" style="color:#AEAEAE;"></i>Offline
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>

        <div class="agent-action-nav">
            <a href="profile_page.php?agent_id=<?php echo $agent_id; ?>" class="agent-nav-btn">
                <i class="fas fa-user"></i> My Profile
            </a>
            <a href="agent_history.php?agent_id=<?php echo $agent_id; ?>" class="agent-nav-btn">
                <i class="fas fa-history"></i> History
            </a>
            <a href="wallet_history.php?agent_id=<?php echo $agent_id; ?>" class="agent-nav-btn">
                <i class="fas fa-wallet"></i> Wallet
            </a>
            <a href="../start.php" class="agent-nav-btn logout-btn">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </div>

    <!-- Content -->
    <div class="row">
        <div class="col-md-12">
            <?php
            if (isset ($_GET['offlineHome'])) include ('offlineHome.php');
            if (isset ($_GET['home']))        include ('home.php');
            if (isset ($_GET['deliver_order'])) include ('deliver_order.php');
            if (isset ($_GET['takeToHome']))  include ('takeToHome.php');
            if (isset ($_GET['takeToOffline'])) include ('takeToOffline.php');
            ?>
        </div>
    </div>

</div>

<!-- Footer -->
<?php include ("../includes/footer.php"); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>
</html>

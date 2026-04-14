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
        body { overflow-x: hidden; background: #F7F2EB; }

        /* ── top navbar ── */
        .agent-topbar {
            background: #1A1A1A;
            border-bottom: 2px solid #FFE6CD;
            padding: 12px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 10px rgba(0,0,0,0.18);
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
        .agent-topbar a:hover { color: #FFE6CD; }
        .agent-topbar .welcome-text { color: #FFE6CD; }

        /* ── status bar ── */
        .agent-status-bar {
            background: #fff;
            border-bottom: 1px solid #FFE6CD;
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
        .status-available { background: #FFE6CD; color: #1A1A1A; border: 1px solid #FFE6CD; }
        .status-offline   { background: #F7F2EB; color: #888; border: 1px solid #AEAEAE; }
        .status-busy      { background: #FFFFFF; color: #1A1A1A; border: 1px solid #FFE6CD; }

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
            color: #1A1A1A;
            background: #F7F2EB;
            border: 1.5px solid #FFE6CD;
            text-decoration: none;
            transition: all 0.2s;
            white-space: nowrap;
        }
        .agent-nav-btn i { color: #1A1A1A; font-size: 0.78rem; }
        .agent-nav-btn:hover {
            background: #FFE6CD;
            border-color: #1A1A1A;
            color: #1A1A1A;
            transform: translateY(-1px);
            box-shadow: 0 3px 10px rgba(0,0,0,0.10);
        }
        .agent-nav-btn.logout-btn {
            background: #FFFFFF;
            border-color: #e0d8d0;
            color: #888;
        }
        .agent-nav-btn.logout-btn i { color: #aaa; }
        .agent-nav-btn.logout-btn:hover {
            background: #F7F2EB;
            border-color: #1A1A1A;
            color: #1A1A1A;
        }
        .agent-nav-btn.logout-btn:hover i { color: #1A1A1A; }

        /* dropdown menu */
        .dropdown-item.active, .dropdown-item:active {
            background-color: #FFE6CD;
            color: #1A1A1A;
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
            <span class="me-1" style="font-size:0.82rem;color:#1A1A1A;font-weight:600;">Status:</span>
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
                                <i class="fas fa-check-circle me-1" style="color:#1A1A1A;"></i>Available
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item <?php echo $current_status === 'Offline' ? 'active' : ''; ?>"
                                href="index.php?agent_id=<?php echo $agent_id; ?>&takeToOffline">
                                <i class="fas fa-moon me-1" style="color:#aaa;"></i>Offline
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

<?php
include ('../functions/common_function.php');

if (isset($_GET['customer_id'])) {
    $cust_id = $_GET['customer_id'];
    $get_data = "SELECT * FROM customer WHERE customerID = $cust_id;";
    $result_get = mysqli_query($con, $get_data);
    $row_data = mysqli_fetch_assoc($result_get);
    $cust_id   = $row_data["customerID"];
    $cust_fname = $row_data['first_name'];
    $cust_lname = $row_data['last_name'];
    $cust_name  = $cust_lname ? "$cust_fname $cust_lname" : $cust_fname;
    $walletBalance = wallet($cust_id);
    $total_items   = cart_total_item($cust_id);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search – ShopEase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../style.css">
    <style>
        body { background: #F7F2EB; overflow-x: hidden; }
    </style>
</head>
<body>

    <!-- Top Bar -->
    <div class="app-topbar">
        <a href="index.php?customer_id=<?php echo $cust_id; ?>" class="brand">
            <i class="fas fa-shopping-bag"></i> ShopEase
        </a>
        <div class="topbar-right">
            <span class="wallet-pill"><i class="fas fa-wallet"></i> ₹<?php echo $walletBalance; ?></span>
            <!-- Cart dropdown -->
            <div class="cart-dropdown-wrap">
                <a href="#" class="cart-topbar-btn">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="cart-count"><?php echo $total_items; ?></span>
                </a>
                <div class="cart-dropdown-panel">
                    <div class="cart-dropdown-header"><h6><i class="fas fa-shopping-cart me-1"></i> My Cart</h6></div>
                    <div class="cart-scroll"><?php show_cart($cust_id); ?></div>
                    <div class="cart-dropdown-footer">
                        <?php
                        $totalPrice  = total_cart($cust_id);
                        $valid_order = check_stock($cust_id);
                        $total_items = cart_total_item($cust_id);
                        $next_page   = ($totalPrice <= $walletBalance) ? "checkout.php?customer_id=$cust_id" : "";
                        ?>
                        <a href="<?php echo $next_page; ?>" onclick="return confirmCheckout()" class="app-nav-btn" style="font-size:0.8rem;padding:5px 12px;">
                            <i class="fas fa-credit-card"></i> Checkout
                        </a>
                        <strong style="color:#1A1A1A; font-size:0.85rem;">₹<?php echo total_cart($cust_id); ?></strong>
                    </div>
                </div>
            </div>
            <span class="welcome-text"><i class="fas fa-user-circle me-1"></i>Welcome, <strong><?php echo $cust_name; ?></strong></span>
        </div>
    </div>

    <!-- Action Nav -->
    <div class="app-action-nav">
        <a href="profile_page.php?customer_id=<?php echo $cust_id; ?>" class="app-nav-btn"><i class="fas fa-user"></i> View Profile</a>
        <a href="view_orders.php?customer_id=<?php echo $cust_id; ?>" class="app-nav-btn"><i class="fas fa-receipt"></i> View Orders</a>
        <a href="index.php?customer_id=<?php echo $cust_id; ?>" class="app-nav-btn"><i class="fas fa-store"></i> Products</a>
        <a href="top_up.php?customer_id=<?php echo $cust_id; ?>" class="app-nav-btn"><i class="fas fa-wallet"></i> Top Up</a>
        <a href="rate_order.php?customer_id=<?php echo $cust_id; ?>" class="app-nav-btn"><i class="fas fa-star"></i> Rate Order</a>
        <a href="rate_delivery.php?customer_id=<?php echo $cust_id; ?>" class="app-nav-btn"><i class="fas fa-truck"></i> Rate Delivery</a>
        <form class="d-flex align-items-center ms-2" role="search" action="" method="get" style="gap:6px;">
            <input type="hidden" name="customer_id" value="<?php echo $cust_id; ?>">
            <input class="form-control" type="search" placeholder="Search products…" name="search_bar"
                style="border-radius:20px;font-size:0.82rem;padding:6px 14px;width:180px;border-color:#FFE6CD;">
            <button type="submit" name="search_data" class="app-nav-btn" style="border:none;background:#1A1A1A;color:#fff;">
                <i class="fas fa-search"></i>
            </button>
        </form>
        <a href="../start.php" class="app-nav-btn logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <?php
    add_to_Cart($cust_id);
    remove_cart($cust_id);
    updateCart($cust_id);
    ?>

    <!-- Search results + category sidebar -->
    <div class="shop-layout">
        <div class="cat-sidebar">
            <h6><i class="fas fa-list me-1"></i> Categories</h6>
            <?php display_categories($cust_id); ?>
        </div>
        <div class="products-area">
            <div class="row g-3">
                <?php search_products($cust_id); ?>
            </div>
        </div>
    </div>

    <?php include('../includes/footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function confirmCheckout() {
            if ("<?php echo $next_page; ?>" === "") {
                alert("Insufficient funds in wallet! Please top up your wallet.");
                return false;
            }
            if ("<?php echo $valid_order; ?>" != "1") {
                alert("<?php echo "$valid_order is out of stock! Please reduce the quantity ordered."; ?>");
                return false;
            }
            if ("<?php echo $total_items; ?>" == 0) {
                alert("Your cart is empty! Add some products first.");
                return false;
            }
            return true;
        }
    </script>
</body>
</html>

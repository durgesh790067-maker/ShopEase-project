<?php
// Shared customer top bar + action nav
// Requires: $cust_id, $cust_name (set by the including page)
?>
<div class="app-topbar">
    <a href="index.php?customer_id=<?php echo $cust_id; ?>" class="brand">
        <i class="fas fa-shopping-bag"></i> ShopEase
    </a>
    <div class="topbar-right">
        <span class="welcome-text"><i class="fas fa-user-circle me-1"></i>Welcome, <strong><?php echo $cust_name; ?></strong></span>
    </div>
</div>

<div class="app-action-nav">
    <a href="profile_page.php?customer_id=<?php echo $cust_id; ?>" class="app-nav-btn">
        <i class="fas fa-user"></i> View Profile
    </a>
    <a href="view_orders.php?customer_id=<?php echo $cust_id; ?>" class="app-nav-btn">
        <i class="fas fa-receipt"></i> View Orders
    </a>
    <a href="index.php?customer_id=<?php echo $cust_id; ?>" class="app-nav-btn">
        <i class="fas fa-store"></i> Products
    </a>
    <a href="top_up.php?customer_id=<?php echo $cust_id; ?>" class="app-nav-btn">
        <i class="fas fa-wallet"></i> Top Up Wallet
    </a>
    <a href="rate_order.php?customer_id=<?php echo $cust_id; ?>" class="app-nav-btn">
        <i class="fas fa-star"></i> Rate Order
    </a>
    <a href="rate_delivery.php?customer_id=<?php echo $cust_id; ?>" class="app-nav-btn">
        <i class="fas fa-truck"></i> Rate Delivery
    </a>
    <a href="../start.php" class="app-nav-btn logout-btn">
        <i class="fas fa-sign-out-alt"></i> Logout
    </a>
</div>

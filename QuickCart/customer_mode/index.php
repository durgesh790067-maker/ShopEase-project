<?php
include ('../functions/common_function.php');

if (isset($_GET['customer_id'])) {
    $cust_id = $_GET['customer_id'];
    $result_get = mysqli_query($con, "SELECT * FROM customer WHERE customerID = $cust_id;");
    $row_data = mysqli_fetch_assoc($result_get);
    $cust_id   = $row_data["customerID"];
    $cust_name = trim($row_data['first_name'] . ' ' . ($row_data['last_name'] ?? ''));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShopEase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../style.css">
    <style>
        body { overflow-x: hidden; background: #F7F2EB; }

        /* ── top bar ── */
        .cust-topbar {
            background: #1A1A1A;
            border-bottom: 2px solid #FFE6CD;
            padding: 12px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 10px rgba(0,0,0,0.18);
            flex-wrap: wrap;
            gap: 10px;
        }
        .cust-topbar .brand {
            font-family: 'Playfair Display', serif;
            font-size: 1.25rem;
            font-weight: 700;
            color: #fff;
            text-decoration: none;
        }
        .cust-topbar .brand i { margin-right: 6px; }
        .cust-topbar .topbar-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .cust-topbar .welcome-text {
            color: #FFE6CD;
            font-size: 0.88rem;
            font-weight: 600;
        }

        /* cart button in topbar */
        .cart-topbar-btn {
            position: relative;
            color: #fff;
            text-decoration: none;
            font-size: 1.1rem;
        }
        .cart-topbar-btn .cart-count {
            position: absolute;
            top: -7px;
            right: -9px;
            background: #1A1A1A;
            color: #fff;
            font-size: 0.6rem;
            font-weight: 700;
            border-radius: 50%;
            width: 16px;
            height: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* wallet pill */
        .wallet-pill {
            background: rgba(255,255,255,0.2);
            color: #fff;
            border-radius: 20px;
            padding: 4px 12px;
            font-size: 0.82rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        /* ── page title ── */
        .cust-page-title {
            text-align: center;
            padding: 16px 16px 6px;
        }
        .cust-page-title h4 {
            font-family: 'Playfair Display', serif;
            color: #1A1A1A;
            font-size: 1.3rem;
            margin: 0;
        }
        .title-divider {
            width: 50px;
            height: 3px;
            background: linear-gradient(90deg, #1A1A1A, #FFE6CD);
            border-radius: 2px;
            margin: 6px auto 0;
        }

        /* ── action nav (same as admin) ── */
        .cust-action-nav {
            background: #fff;
            border-top: 1px solid #FFE6CD;
            border-bottom: 1px solid #FFE6CD;
            padding: 10px 20px;
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            justify-content: center;
            align-items: center;
        }
        .cust-nav-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 16px;
            border-radius: 20px;
            font-size: 0.82rem;
            font-weight: 600;
            color: #1A1A1A;
            background: #F7F2EB;
            border: 1.5px solid #FFE6CD;
            text-decoration: none;
            transition: all 0.2s ease;
            white-space: nowrap;
        }
        .cust-nav-btn i { font-size: 0.78rem; color: #1A1A1A; }
        .cust-nav-btn:hover {
            background: #FFE6CD;
            border-color: #1A1A1A;
            color: #1A1A1A;
            transform: translateY(-1px);
            box-shadow: 0 3px 10px rgba(0,0,0,0.12);
        }
        .cust-nav-btn.logout-btn {
            background: #FFFFFF;
            border-color: #e0d8d0;
            color: #888;
        }
        .cust-nav-btn.logout-btn i { color: #aaa; }
        .cust-nav-btn.logout-btn:hover {
            background: #F7F2EB;
            border-color: #1A1A1A;
            color: #1A1A1A;
        }
        .cust-nav-btn.logout-btn:hover i { color: #1A1A1A; }

        /* search inside nav */
        .search-form {
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .search-form input {
            border: 1.5px solid #FFE6CD;
            border-radius: 20px;
            padding: 5px 14px;
            font-size: 0.8rem;
            outline: none;
            background: #FFFFFF;
            color: #1A1A1A;
            width: 160px;
            transition: border-color 0.2s;
        }
        .search-form input:focus { border-color: #1A1A1A; }
        .search-form button {
            background: #1A1A1A;
            color: #fff;
            border: none;
            border-radius: 20px;
            padding: 6px 14px;
            font-size: 0.78rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }
        .search-form button:hover { background: rgba(0,0,0,0.85); }

        /* ── promo banner ── */
        .promo-banner {
            background: #FFE6CD;
            text-align: center;
            padding: 8px;
            font-size: 0.82rem;
            color: #1A1A1A;
            letter-spacing: 1px;
            border-bottom: 1px solid #FFE6CD;
        }

        /* ── layout ── */
        .shop-layout { display: flex; align-items: flex-start; min-height: 80vh; }

        /* ── category sidebar ── */
        .cat-sidebar {
            width: 175px;
            min-width: 175px;
            background: #fff;
            border-right: 1px solid #FFE6CD;
            padding: 20px 12px;
            position: sticky;
            top: 0;
            min-height: 80vh;
        }
        .cat-sidebar h6 {
            font-family: 'Playfair Display', serif;
            color: #1A1A1A;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 14px;
            padding-bottom: 8px;
            border-bottom: 2px solid #FFE6CD;
        }
        .cat-link {
            display: block;
            padding: 7px 10px;
            border-radius: 8px;
            font-size: 0.82rem;
            color: #1A1A1A;
            text-decoration: none;
            margin-bottom: 3px;
            transition: background 0.2s, color 0.2s;
        }
        .cat-link:hover, .cat-link.cat-active {
            background: #FFE6CD;
            color: #1A1A1A;
            font-weight: 600;
        }
        .cat-all-link {
            display: block;
            padding: 7px 10px;
            border-radius: 8px;
            font-size: 0.82rem;
            color: #1A1A1A;
            font-weight: 700;
            text-decoration: none;
            margin-bottom: 8px;
            background: #F7F2EB;
        }

        /* ── products area ── */
        .products-area { flex: 1; padding: 20px; overflow: hidden; }

        /* ── product card ── */
        .prod-card {
            background: #fff;
            border: 1px solid #FFE6CD;
            border-radius: 16px;
            overflow: hidden;
            transition: box-shadow 0.3s, transform 0.3s;
            display: flex;
            flex-direction: column;
        }
        .prod-card:hover {
            box-shadow: 0 8px 28px rgba(0,0,0,0.12);
            transform: translateY(-4px);
        }
        .prod-card__img-wrap {
            background: #FFFFFF;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 160px;
            padding: 12px;
            border-bottom: 1px solid #F7F2EB;
        }
        .prod-card__img-wrap img {
            max-height: 130px;
            max-width: 100%;
            object-fit: contain;
        }
        .prod-card__body {
            padding: 14px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        .prod-card__name {
            font-family: 'Playfair Display', serif;
            font-size: 0.95rem;
            font-weight: 700;
            color: #1A1A1A;
            margin-bottom: 5px;
            line-height: 1.3;
        }
        .prod-card__desc {
            font-size: 0.78rem;
            color: #888;
            line-height: 1.4;
            flex-grow: 1;
            margin-bottom: 12px;
        }
        .prod-card__footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .prod-card__price {
            font-size: 1rem;
            font-weight: 700;
            color: #1A1A1A;
        }
        .prod-card__btn {
            background: #1A1A1A;
            color: #fff;
            border: none;
            border-radius: 20px;
            padding: 5px 14px;
            font-size: 0.78rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
        }
        .prod-card__btn:hover {
            background: rgba(0,0,0,0.85);
            color: #fff;
            transform: translateY(-1px);
        }

        /* ── cart dropdown ── */
        .cart-dropdown-wrap {
            position: relative;
            display: inline-block;
        }
        .cart-dropdown-panel {
            display: none;
            position: absolute;
            right: 0;
            top: calc(100% + 10px);
            width: 310px;
            background: #fff;
            border: 1px solid #FFE6CD;
            border-radius: 14px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.10);
            z-index: 9999;
        }
        .cart-dropdown-wrap:hover .cart-dropdown-panel,
        .cart-dropdown-panel:hover { display: block; }
        .cart-dropdown-header { padding: 12px; border-bottom: 1px solid #FFE6CD; text-align: center; }
        .cart-dropdown-header h6 { font-family: 'Playfair Display', serif; color: #1A1A1A; margin: 0; font-size: 0.95rem; }
        .cart-scroll { max-height: 45vh; overflow-y: auto; }
        .cart-item {
            display: flex;
            gap: 10px;
            padding: 10px;
            border-bottom: 1px solid #F7F2EB;
        }
        .cart-item img { width: 50px; height: 50px; object-fit: contain; border-radius: 8px; background: #FFFFFF; }
        .cart-item-info { flex: 1; }
        .cart-item-name { font-size: 0.82rem; color: #1A1A1A; font-weight: 600; margin: 0 0 2px; }
        .cart-item-price { font-size: 0.78rem; color: #888; margin: 0 0 5px; }
        .cart-item-actions { display: flex; align-items: center; gap: 8px; }
        .qty-btn {
            background: #FFE6CD;
            color: #1A1A1A;
            border: none;
            border-radius: 50%;
            width: 22px; height: 22px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.85rem;
            text-decoration: none;
            transition: background 0.2s;
        }
        .qty-btn:hover { background: #1A1A1A; color: #FFE6CD; }
        .remove-btn { color: #1A1A1A; font-size: 0.75rem; text-decoration: none; margin-left: 6px; }
        .remove-btn:hover { color: #1A1A1A; }
        .cart-dropdown-footer {
            padding: 10px;
            border-top: 1px solid #FFE6CD;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* responsive */
        @media(max-width:768px) {
            .cat-sidebar { display: none; }
            .products-area { padding: 12px; }
            .search-form input { width: 110px; }
            .cust-topbar { padding: 10px 14px; }
        }
    </style>
</head>
<body>

<?php
add_to_Cart($cust_id);
remove_cart($cust_id);
updateCart($cust_id);
$totalPrice    = total_cart($cust_id);
$walletBalance = wallet($cust_id);
$valid_order   = check_stock($cust_id);
$total_items   = cart_total_item($cust_id);
$next_page     = ($totalPrice <= $walletBalance) ? "checkout.php?customer_id=$cust_id" : "";
?>

<!-- Top bar -->
<div class="cust-topbar">
    <a href="index.php?customer_id=<?php echo $cust_id; ?>" class="brand">
        <i class="fas fa-shopping-bag"></i> ShopEase
    </a>
    <div class="topbar-right">
        <span class="wallet-pill"><i class="fas fa-wallet"></i> ₹<?php echo $walletBalance; ?></span>

        <!-- Cart hover dropdown -->
        <div class="cart-dropdown-wrap">
            <a href="#" class="cart-topbar-btn">
                <i class="fas fa-shopping-cart"></i>
                <span class="cart-count"><?php cart_item($cust_id); ?></span>
            </a>
            <div class="cart-dropdown-panel">
                <div class="cart-dropdown-header"><h6><i class="fas fa-shopping-cart me-1"></i>My Cart</h6></div>
                <div class="cart-scroll"><?php show_cart($cust_id); ?></div>
                <div class="cart-dropdown-footer">
                    <strong style="color:#1A1A1A;">₹<?php echo $totalPrice; ?></strong>
                    <a href="<?php echo $next_page; ?>" onclick="return confirmCheckout()" class="btn btn-pastel btn-sm">Checkout</a>
                </div>
            </div>
        </div>

        <span class="welcome-text"><i class="fas fa-user-circle me-1"></i>Welcome, <strong><?php echo $cust_name; ?></strong></span>
    </div>
</div>

<!-- Promo banner -->
<div class="promo-banner">✨ Free delivery on orders above ₹500 &nbsp;|&nbsp; Holi Special Savings with ShopEase! ✨</div>

<!-- Action Nav -->
<div class="cust-action-nav">
    <a href="profile_page.php?customer_id=<?php echo $cust_id; ?>" class="cust-nav-btn">
        <i class="fas fa-user"></i> View Profile
    </a>
    <a href="view_orders.php?customer_id=<?php echo $cust_id; ?>" class="cust-nav-btn">
        <i class="fas fa-receipt"></i> View Orders
    </a>
    <a href="top_up.php?customer_id=<?php echo $cust_id; ?>" class="cust-nav-btn">
        <i class="fas fa-wallet"></i> Top Up Wallet
    </a>
    <a href="rate_order.php?customer_id=<?php echo $cust_id; ?>" class="cust-nav-btn">
        <i class="fas fa-star"></i> Rate Order
    </a>
    <a href="rate_delivery.php?customer_id=<?php echo $cust_id; ?>" class="cust-nav-btn">
        <i class="fas fa-truck"></i> Rate Delivery
    </a>

    <!-- Search -->
    <form class="search-form" action="search_bar.php" method="get">
        <input type="hidden" name="customer_id" value="<?php echo $cust_id; ?>">
        <input type="search" placeholder="Search products…" name="search_bar">
        <button type="submit" name="search_data"><i class="fas fa-search"></i></button>
    </form>

    <a href="../start.php" class="cust-nav-btn logout-btn">
        <i class="fas fa-sign-out-alt"></i> Logout
    </a>
</div>

<!-- Main shop layout -->
<div class="shop-layout">
    <!-- Category Sidebar -->
    <aside class="cat-sidebar">
        <h6><i class="fas fa-th-list me-1"></i> Categories</h6>
        <a href="index.php?customer_id=<?php echo $cust_id; ?>" class="cat-all-link">All Products</a>
        <?php display_categories($cust_id); ?>
    </aside>

    <!-- Products -->
    <main class="products-area">
        <div class="row g-3">
            <?php
            display_products($cust_id);
            display_cat_products($cust_id);
            search_products($cust_id);
            ?>
        </div>
    </main>
</div>

<!-- Footer -->
<?php include("../includes/footer.php"); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function confirmCheckout() {
    if ("<?php echo $next_page; ?>" === "") {
        alert("Insufficient wallet balance. Please top up in 'Top Up Wallet'.");
        return false;
    }
    if ("<?php echo $valid_order; ?>" != "1" && "<?php echo $valid_order; ?>" !== true) {
        alert("<?php echo "$valid_order is out of stock! Reduce quantity or try later."; ?>");
        return false;
    }
    if (<?php echo $total_items; ?> == 0) {
        alert("Your cart is empty. Add some products first!");
        return false;
    }
    return true;
}
</script>
</body>
</html>

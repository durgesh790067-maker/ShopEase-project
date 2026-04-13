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
        body { overflow-x: hidden; background: #fdf6f0; }

        /* ── welcome bar ── */
        .welcome-bar {
            background: #f9e8e8;
            border-bottom: 1px solid #f0d5d5;
            padding: 6px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.88rem;
            color: #7d4a4a;
        }
        .welcome-bar a { color: #c97b7b; font-weight: 600; text-decoration: none; }
        .welcome-bar a:hover { color: #b56868; }

        /* ── promo banner ── */
        .promo-banner {
            background: linear-gradient(90deg, #f9e0e0, #fdf6f0, #f9e0e0);
            text-align: center;
            padding: 10px;
            font-size: 0.85rem;
            color: #b58585;
            letter-spacing: 1px;
            border-bottom: 1px solid #f0d5d5;
        }

        /* ── layout ── */
        .shop-layout { display: flex; align-items: flex-start; min-height: 80vh; }

        /* ── category sidebar ── */
        .cat-sidebar {
            width: 175px;
            min-width: 175px;
            background: #fff;
            border-right: 1px solid #f0d5d5;
            padding: 20px 12px;
            position: sticky;
            top: 0;
            min-height: 80vh;
        }
        .cat-sidebar h6 {
            font-family: 'Playfair Display', serif;
            color: #7d4a4a;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 14px;
            padding-bottom: 8px;
            border-bottom: 2px solid #f2c4ce;
        }
        .cat-link {
            display: block;
            padding: 7px 10px;
            border-radius: 8px;
            font-size: 0.82rem;
            color: #7d4a4a;
            text-decoration: none;
            margin-bottom: 3px;
            transition: background 0.2s, color 0.2s;
        }
        .cat-link:hover, .cat-link.cat-active {
            background: #f9e8e8;
            color: #c97b7b;
            font-weight: 600;
        }
        .cat-all-link {
            display: block;
            padding: 7px 10px;
            border-radius: 8px;
            font-size: 0.82rem;
            color: #c97b7b;
            font-weight: 700;
            text-decoration: none;
            margin-bottom: 8px;
            background: #fdf6f0;
        }

        /* ── products area ── */
        .products-area { flex: 1; padding: 20px; overflow: hidden; }

        /* ── product card ── */
        .prod-card {
            background: #fff;
            border: 1px solid #f0d5d5;
            border-radius: 16px;
            overflow: hidden;
            transition: box-shadow 0.3s, transform 0.3s;
            display: flex;
            flex-direction: column;
        }
        .prod-card:hover {
            box-shadow: 0 8px 28px rgba(180,120,120,0.18);
            transform: translateY(-4px);
        }
        .prod-card__img-wrap {
            background: #fff8f5;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 160px;
            padding: 12px;
            border-bottom: 1px solid #f9e8e8;
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
            color: #5a3e3e;
            margin-bottom: 5px;
            line-height: 1.3;
        }
        .prod-card__desc {
            font-size: 0.78rem;
            color: #b58585;
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
            color: #c97b7b;
        }
        .prod-card__btn {
            background: linear-gradient(135deg, #c97b7b, #d4a5a5);
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
            background: linear-gradient(135deg, #b56868, #c97b7b);
            color: #fff;
            transform: translateY(-1px);
        }

        /* ── cart items in dropdown ── */
        .cart-item {
            display: flex;
            gap: 10px;
            padding: 10px;
            border-bottom: 1px solid #f9e8e8;
        }
        .cart-item img { width: 50px; height: 50px; object-fit: contain; border-radius: 8px; background: #fff8f5; }
        .cart-item-info { flex: 1; }
        .cart-item-name { font-size: 0.82rem; color: #5a3e3e; font-weight: 600; margin: 0 0 2px; }
        .cart-item-price { font-size: 0.78rem; color: #b58585; margin: 0 0 5px; }
        .cart-item-actions { display: flex; align-items: center; gap: 8px; }
        .qty-btn {
            background: #f9e8e8;
            color: #c97b7b;
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
        .qty-btn:hover { background: #e8c4c4; color: #fff; }
        .remove-btn { color: #c97b7b; font-size: 0.75rem; text-decoration: none; margin-left: 6px; }
        .remove-btn:hover { color: #b56868; }

        /* ── checkout button ── */
        .cart-dropdown-footer { padding: 10px; border-top: 1px solid #f0d5d5; display: flex; justify-content: space-between; align-items: center; }
        .cart-dropdown-header { padding: 12px; border-bottom: 1px solid #f0d5d5; }
        .cart-dropdown-header h6 { font-family: 'Playfair Display', serif; color: #7d4a4a; margin: 0; }

        /* responsive */
        @media(max-width:768px) {
            .cat-sidebar { display: none; }
            .products-area { padding: 12px; }
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg bg-pastel">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><i class="fas fa-shopping-bag me-1"></i> ShopEase</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navTop">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navTop">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="profile_page.php?customer_id=<?php echo $cust_id; ?>">
                        <i class="fas fa-user me-1"></i>My Profile
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?customer_id=<?php echo $cust_id; ?>">
                        <i class="fas fa-store me-1"></i>Products
                    </a>
                </li>
                <!-- Cart -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="cartDrop" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-shopping-cart"></i>
                        <sup><span class="badge rounded-pill" style="background:#c97b7b;font-size:0.65rem;"><?php cart_item($cust_id); ?></span></sup>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" style="width:320px;padding:0;" aria-labelledby="cartDrop">
                        <div class="cart-dropdown-header text-center"><h6>My Cart</h6></div>
                        <div style="max-height:45vh;overflow-y:auto;"><?php show_cart($cust_id); ?></div>
                        <div class="cart-dropdown-footer">
                            <?php
                            $totalPrice = total_cart($cust_id);
                            $walletBalance = wallet($cust_id);
                            $valid_order = check_stock($cust_id);
                            $total_items = cart_total_item($cust_id);
                            $next_page = ($totalPrice <= $walletBalance) ? "checkout.php?customer_id=$cust_id" : "";
                            ?>
                            <strong style="color:#c97b7b;">₹<?php echo $totalPrice; ?></strong>
                            <a href="<?php echo $next_page; ?>" onclick="return confirmCheckout()" class="btn btn-pastel btn-sm">Checkout</a>
                        </div>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-wallet me-1"></i>₹<?php echo wallet($cust_id); ?>
                    </a>
                </li>
            </ul>
            <!-- Search -->
            <form class="d-flex" role="search" action="search_bar.php" method="get">
                <input type="hidden" name="customer_id" value="<?php echo $cust_id; ?>">
                <input class="form-control me-2" type="search" placeholder="Search products…" name="search_bar" style="border-radius:20px;border-color:#e8c4c4;">
                <button type="submit" class="btn btn-pastel btn-sm" name="search_data" style="white-space:nowrap;">Search</button>
            </form>
        </div>
    </div>
</nav>

<!-- Welcome bar -->
<div class="welcome-bar">
    <span><i class="fas fa-hand-wave me-1"></i> Welcome, <strong><?php echo $cust_name; ?></strong></span>
    <a href="../start.php"><i class="fas fa-sign-out-alt me-1"></i>Logout</a>
</div>

<!-- Promo banner -->
<div class="promo-banner">✨ Free delivery on orders above ₹500 &nbsp;|&nbsp; Holi Special Savings with ShopEase! ✨</div>

<?php
add_to_Cart($cust_id);
remove_cart($cust_id);
updateCart($cust_id);
?>

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
        alert("Insufficient wallet balance. Please top up in 'My Profile'.");
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

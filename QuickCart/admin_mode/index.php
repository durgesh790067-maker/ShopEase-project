<?php
include ("../functions/common_function.php");

if (isset($_GET['admin_id'])) {
    $admin_id = $_GET['admin_id'];
    $name = ($admin_id == 5) ? "Durgesh" : (($admin_id == 6) ? "Roshni" : "Admin");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin – ShopEase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../style.css">
    <style>
        body { overflow-x: hidden; background: #fdf6f0; }

        /* ── top navbar ── */
        .admin-topbar {
            background: linear-gradient(90deg, #e8c4c4 0%, #f2d4d4 100%);
            border-bottom: 1px solid #d4a5a5;
            padding: 12px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .admin-topbar .brand {
            font-family: 'Playfair Display', serif;
            font-size: 1.25rem;
            font-weight: 700;
            color: #7d4a4a;
            text-decoration: none;
        }
        .admin-topbar .brand i { margin-right: 6px; color: #c97b7b; }
        .admin-topbar .topbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
            font-size: 0.88rem;
        }
        .admin-topbar a {
            color: #7d4a4a;
            text-decoration: none;
            font-weight: 600;
        }
        .admin-topbar a:hover { color: #c97b7b; }

        /* ── page title ── */
        .admin-page-title {
            text-align: center;
            padding: 20px 16px 8px;
        }
        .admin-page-title h4 {
            font-family: 'Playfair Display', serif;
            color: #7d4a4a;
            font-size: 1.4rem;
            margin: 0;
        }
        .title-divider {
            width: 50px;
            height: 3px;
            background: linear-gradient(90deg, #c97b7b, #f2c4ce);
            border-radius: 2px;
            margin: 8px auto 0;
        }

        /* ── action nav ── */
        .admin-action-nav {
            background: #fff;
            border-top: 1px solid #f0d5d5;
            border-bottom: 1px solid #f0d5d5;
            padding: 12px 20px;
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            justify-content: center;
        }
        .admin-nav-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 16px;
            border-radius: 20px;
            font-size: 0.82rem;
            font-weight: 600;
            color: #7d4a4a;
            background: #fdf6f0;
            border: 1.5px solid #e8c4c4;
            text-decoration: none;
            transition: all 0.2s ease;
            white-space: nowrap;
        }
        .admin-nav-btn i { font-size: 0.78rem; color: #c97b7b; }
        .admin-nav-btn:hover {
            background: #f9e8e8;
            border-color: #c97b7b;
            color: #c97b7b;
            transform: translateY(-1px);
            box-shadow: 0 3px 10px rgba(180,120,120,0.15);
        }
        .admin-nav-btn.logout-btn {
            background: #fff0f0;
            border-color: #f0b8b8;
            color: #b56868;
        }
        .admin-nav-btn.logout-btn:hover {
            background: #ffe0e0;
            border-color: #c97b7b;
        }

        /* ── content area ── */
        .admin-content { padding: 24px; }

        .prod_image { width: 100px; height: 100px; object-fit: contain; }
        .edit_image  { width: 100%; height: 100px; object-fit: contain; }
    </style>
</head>
<body>

<!-- Top bar -->
<div class="admin-topbar">
    <a href="index.php?admin_id=<?php echo $admin_id; ?>&home" class="brand">
        <i class="fas fa-shopping-bag"></i> ShopEase
    </a>
    <div class="topbar-right">
        <a href="index.php?admin_id=<?php echo $admin_id; ?>&home">
            <i class="fas fa-home me-1"></i>Home
        </a>
        <span style="color:#b58585;"><i class="fas fa-user-shield me-1"></i>Welcome, <strong><?php echo $name; ?></strong></span>
    </div>
</div>

<!-- Page Title -->
<div class="admin-page-title">
    <h4><i class="fas fa-boxes me-2" style="color:#c97b7b;"></i>Manage Inventory &amp; View Analysis</h4>
    <div class="title-divider"></div>
</div>

<!-- Action Nav -->
<div class="admin-action-nav">
    <a href="index.php?admin_id=<?php echo $admin_id; ?>&insert_product" class="admin-nav-btn">
        <i class="fas fa-plus-circle"></i> Insert Products
    </a>
    <a href="index.php?admin_id=<?php echo $admin_id; ?>&view_product" class="admin-nav-btn">
        <i class="fas fa-box-open"></i> View Products
    </a>
    <a href="index.php?admin_id=<?php echo $admin_id; ?>&insert_category" class="admin-nav-btn">
        <i class="fas fa-folder-plus"></i> Insert Category
    </a>
    <a href="index.php?admin_id=<?php echo $admin_id; ?>&view_category" class="admin-nav-btn">
        <i class="fas fa-tags"></i> View Categories
    </a>
    <a href="index.php?admin_id=<?php echo $admin_id; ?>&view_orders" class="admin-nav-btn">
        <i class="fas fa-receipt"></i> All Orders
    </a>
    <a href="index.php?admin_id=<?php echo $admin_id; ?>&list_customers" class="admin-nav-btn">
        <i class="fas fa-users"></i> Customers
    </a>
    <a href="index.php?admin_id=<?php echo $admin_id; ?>&list_agents" class="admin-nav-btn">
        <i class="fas fa-truck"></i> Delivery Agents
    </a>
    <a href="index.php?admin_id=<?php echo $admin_id; ?>&order_review" class="admin-nav-btn">
        <i class="fas fa-star"></i> Order Reviews
    </a>
    <a href="index.php?admin_id=<?php echo $admin_id; ?>&delivery_review" class="admin-nav-btn">
        <i class="fas fa-comment-dots"></i> Delivery Reviews
    </a>
    <a href="../start.php" class="admin-nav-btn logout-btn">
        <i class="fas fa-sign-out-alt"></i> Logout
    </a>
</div>

<!-- Content -->
<div class="admin-content">
    <?php
    if (isset($_GET['insert_category']))  include('insert_category.php');
    if (isset($_GET['insert_product']))   include('insert_product.php');
    if (isset($_GET['view_product']))     include('view_product.php');
    if (isset($_GET['edit_product']))     include('edit_product.php');
    if (isset($_GET['delete_product']))   include('delete_product.php');
    if (isset($_GET['view_category']))    include('view_category.php');
    if (isset($_GET['edit_category']))    include('edit_category.php');
    if (isset($_GET['delete_category']))  include('delete_category.php');
    if (isset($_GET['view_orders']))      include('view_orders.php');
    if (isset($_GET['list_customers']))   include('list_customers.php');
    if (isset($_GET['list_agents']))      include('list_agents.php');
    if (isset($_GET['order_review']))     include('order_review.php');
    if (isset($_GET['delivery_review']))  include('delivery_review.php');
    if (isset($_GET['home']))             include('home.php');
    if (isset($_GET['dispatch_order']))   include('dispatch_order.php');
    ?>
</div>

<!-- Footer -->
<?php include("../includes/footer.php"); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
include ('../includes/connect.php');

// ── shared card HTML helper ──────────────────────────────────────────────────
function product_card_html($prod_id, $prod_name, $prod_desc, $prod_image, $prod_price, $cust_id) {
    $short_desc = mb_strlen($prod_desc) > 72 ? mb_substr($prod_desc, 0, 72) . '…' : $prod_desc;
    return "
    <div class='col-6 col-md-4 col-lg-3 mb-4'>
      <div class='prod-card h-100'>
        <div class='prod-card__img-wrap'>
          <img src='../images/$prod_image' alt='$prod_name'>
        </div>
        <div class='prod-card__body'>
          <p class='prod-card__name'>$prod_name</p>
          <p class='prod-card__desc'>$short_desc</p>
          <div class='prod-card__footer'>
            <span class='prod-card__price'>₹$prod_price</span>
            <a href='index.php?add_to_cart=$prod_id&customer_id=$cust_id' class='prod-card__btn'>
              <i class='fas fa-cart-plus'></i> Add
            </a>
          </div>
        </div>
      </div>
    </div>";
}

// ── Guest-mode helper: product card without customer_id ───────────────────────
function product_card_html_guest($prod_id, $prod_name, $prod_desc, $prod_image, $prod_price) {
    $short_desc = mb_strlen($prod_desc) > 72 ? mb_substr($prod_desc, 0, 72) . '…' : $prod_desc;
    return "
    <div class='col-6 col-md-4 col-lg-3 mb-4'>
      <div class='prod-card h-100'>
        <div class='prod-card__img-wrap'>
          <img src='../images/$prod_image' alt='$prod_name'>
        </div>
        <div class='prod-card__body'>
          <p class='prod-card__name'>$prod_name</p>
          <p class='prod-card__desc'>$short_desc</p>
          <div class='prod-card__footer'>
            <span class='prod-card__price'>₹$prod_price</span>
            <button class='prod-card__btn' onclick='openLoginModal($prod_id)'>
              <i class='fas fa-cart-plus'></i> Add
            </button>
          </div>
        </div>
      </div>
    </div>";
}

function display_products_guest() {
    global $con;
    if (!isset($_GET['cat'])) {
        $result_prod = mysqli_query($con, "SELECT * FROM product;");
        if (mysqli_num_rows($result_prod) == 0) {
            echo "<p class='text-center text-muted py-5'>No products available right now.</p>";
        }
        while ($row = mysqli_fetch_assoc($result_prod)) {
            echo product_card_html_guest($row['productID'], $row['name'], $row['description'], $row['prod_image'], $row['price']);
        }
    }
}

function display_cat_products_guest() {
    global $con;
    if (isset($_GET['cat'])) {
        $cat_id = intval($_GET['cat']);
        $result_prod = mysqli_query($con, "SELECT * FROM product WHERE categoryID = $cat_id;");
        if (mysqli_num_rows($result_prod) == 0) {
            echo "<p class='text-center text-muted py-5'>No products in this category yet.</p>";
        }
        while ($row = mysqli_fetch_assoc($result_prod)) {
            echo product_card_html_guest($row['productID'], $row['name'], $row['description'], $row['prod_image'], $row['price']);
        }
    }
}

function display_categories_guest() {
    global $con;
    $cat_result = mysqli_query($con, "SELECT * FROM productCategory;");
    while ($row = mysqli_fetch_assoc($cat_result)) {
        $cat_name = $row["name"];
        $cat_id   = $row["categoryID"];
        $active   = (isset($_GET['cat']) && $_GET['cat'] == $cat_id) ? 'cat-active' : '';
        echo "<a href='index.php?cat=$cat_id' class='cat-link $active'>$cat_name</a>";
    }
}

function search_products_guest() {
    global $con;
    if (isset($_GET['search_data'])) {
        $searched_word = $_GET['search_bar'];
        $result_prod = mysqli_query($con, "SELECT * FROM product WHERE name LIKE '%$searched_word%' AND stock>0;");
        if (mysqli_num_rows($result_prod) == 0) {
            echo "<p class='text-center text-muted py-5'>No results found for \"$searched_word\".</p>";
        }
        while ($row = mysqli_fetch_assoc($result_prod)) {
            echo product_card_html_guest($row['productID'], $row['name'], $row['description'], $row['prod_image'], $row['price']);
        }
    }
}

// display all products on home-page
function display_products($cust_id) {
    global $con;
    if (!isset($_GET['cat'])) {
        $result_prod = mysqli_query($con, "SELECT * FROM product;");
        if (mysqli_num_rows($result_prod) == 0) {
            echo "<p class='text-center text-muted py-5'>No products available right now.</p>";
        }
        while ($row = mysqli_fetch_assoc($result_prod)) {
            echo product_card_html($row['productID'], $row['name'], $row['description'], $row['prod_image'], $row['price'], $cust_id);
        }
    }
}

// display unique category products only
function display_cat_products($cust_id) {
    global $con;
    if (isset($_GET['cat'])) {
        $cat_id = $_GET['cat'];
        $result_prod = mysqli_query($con, "SELECT * FROM product WHERE categoryID = $cat_id;");
        if (mysqli_num_rows($result_prod) == 0) {
            echo "<p class='text-center text-muted py-5'>No products in this category yet.</p>";
        }
        while ($row = mysqli_fetch_assoc($result_prod)) {
            echo product_card_html($row['productID'], $row['name'], $row['description'], $row['prod_image'], $row['price'], $cust_id);
        }
    }
}

// display categories on side-nav
function display_categories($cust_id) {
    global $con;
    $cat_result = mysqli_query($con, "SELECT * FROM productCategory;");
    while ($row = mysqli_fetch_assoc($cat_result)) {
        $cat_name = $row["name"];
        $cat_id   = $row["categoryID"];
        $active   = (isset($_GET['cat']) && $_GET['cat'] == $cat_id) ? 'cat-active' : '';
        echo "<a href='index.php?customer_id=$cust_id&cat=$cat_id' class='cat-link $active'>$cat_name</a>";
    }
}

// displaying products searched
function search_products($cust_id) {
    global $con;
    if (isset($_GET['search_data'])) {
        $searched_word = $_GET['search_bar'];
        $result_prod = mysqli_query($con, "SELECT * FROM product WHERE name LIKE '%$searched_word%' AND stock>0;");
        if (mysqli_num_rows($result_prod) == 0) {
            echo "<p class='text-center text-muted py-5'>No results found for \"$searched_word\".</p>";
        }
        while ($row = mysqli_fetch_assoc($result_prod)) {
            echo product_card_html($row['productID'], $row['name'], $row['description'], $row['prod_image'], $row['price'], $cust_id);
        }
    }
}

// function for adding products to cart
function add_to_Cart($cust_id) {
    if (isset($_GET['add_to_cart'])) {
        global $con;
        $prod_id = $_GET['add_to_cart'];
        $user_id = $cust_id;
        $result_query = mysqli_query($con, "SELECT * FROM addstocart WHERE productID = '$prod_id' AND customerID = '$user_id'");
        if (mysqli_num_rows($result_query) > 0) {
            echo "<script>alert('Product already added to cart!')</script>";
            echo "<script>window.open('index.php?customer_id=$cust_id', '_self')</script>";
        } else {
            $result_cart = mysqli_query($con, "INSERT INTO addstocart (customerID, productID, quantity) VALUES ('$user_id', '$prod_id', 1)");
            if ($result_cart) {
                echo "<script>alert('Product added to cart successfully!')</script>";
                echo "<script>window.open('index.php?customer_id=$cust_id', '_self')</script>";
            }
        }
    }
}

function cart_item($cust_id) {
    global $con;
    $result_cart = mysqli_query($con, "SELECT * FROM addstocart WHERE customerID = '$cust_id'");
    echo mysqli_num_rows($result_cart);
}

function cart_total_item($cust_id) {
    global $con;
    $result_cart = mysqli_query($con, "SELECT * FROM addstocart WHERE customerID = '$cust_id'");
    return mysqli_num_rows($result_cart);
}

function total_cart($cust_id) {
    global $con;
    $total = 0;
    $result_cart = mysqli_query($con, "SELECT * FROM addstocart WHERE customerID = '$cust_id'");
    while ($row_cart = mysqli_fetch_assoc($result_cart)) {
        $result_prod = mysqli_query($con, "SELECT * FROM product WHERE productID = '{$row_cart['productID']}'");
        $row_prod = mysqli_fetch_assoc($result_prod);
        $total += $row_prod['price'] * $row_cart['quantity'];
    }
    return $total;
}

function remove_cart($cust_id) {
    if (isset($_GET['remove_cart'])) {
        global $con;
        $prod_id = $_GET['remove_cart'];
        $result_cart = mysqli_query($con, "DELETE FROM addstocart WHERE productID = '$prod_id' AND customerID = '$cust_id'");
        if ($result_cart) {
            echo "<script>alert('Product removed from cart successfully!')</script>";
            echo "<script>window.open('index.php?customer_id=$cust_id', '_self')</script>";
        }
    }
}

function show_cart($cust_id) {
    global $con;
    $result_cart = mysqli_query($con, "SELECT * FROM addstocart WHERE customerID = '$cust_id'");
    if (mysqli_num_rows($result_cart) == 0) {
        echo "<p class='text-center text-muted p-3'>Your cart is empty.</p>";
    }
    while ($row_cart = mysqli_fetch_assoc($result_cart)) {
        $prod_id  = $row_cart['productID'];
        $prod_qty = $row_cart['quantity'];
        $result_prod = mysqli_query($con, "SELECT * FROM product WHERE productID = '$prod_id'");
        while ($row_prod = mysqli_fetch_assoc($result_prod)) {
            $prod_name  = $row_prod['name'];
            $prod_image = $row_prod['prod_image'];
            $prod_price = $row_prod['price'];
            echo "<div class='cart-item'>
                <img src='../images/$prod_image' alt='$prod_name'>
                <div class='cart-item-info'>
                  <p class='cart-item-name'>$prod_name</p>
                  <p class='cart-item-price'>₹$prod_price &times; $prod_qty</p>
                  <div class='cart-item-actions'>
                    <a href='index.php?update_qnt=$prod_id&update_val=-1&customer_id=$cust_id' class='qty-btn'>−</a>
                    <span>$prod_qty</span>
                    <a href='index.php?update_qnt=$prod_id&update_val=1&customer_id=$cust_id' class='qty-btn'>+</a>
                    <a href='index.php?remove_cart=$prod_id&customer_id=$cust_id' class='remove-btn'>✕</a>
                  </div>
                </div>
              </div>";
        }
    }
}

function wallet($cust_id) {
    global $con;
    $result_wallet = mysqli_query($con, "SELECT * FROM wallet WHERE customerID = '$cust_id'");
    $row_wallet = mysqli_fetch_assoc($result_wallet);
    return $row_wallet['balance'];
}

function updateCart($cust_id) {
    if (isset($_GET['update_qnt'])) {
        global $con;
        $prod_id    = $_GET['update_qnt'];
        $update_val = $_GET['update_val'];
        $result_cart = mysqli_query($con, "SELECT * FROM addstocart WHERE productID = '$prod_id' AND customerID = '$cust_id'");
        $row_cart    = mysqli_fetch_assoc($result_cart);
        $new_qty     = $row_cart['quantity'] + $update_val;
        if ($new_qty < 1) {
            echo "<script>alert('Quantity cannot be less than 1! Click Remove to delete.')</script>";
            echo "<script>window.open('index.php?customer_id=$cust_id', '_self')</script>";
        }
        $result_update = mysqli_query($con, "UPDATE addstocart SET quantity = '$new_qty' WHERE productID = '$prod_id' AND customerID = '$cust_id'");
        if ($result_update) {
            echo "<script>alert('Cart updated successfully!')</script>";
            echo "<script>window.open('index.php?customer_id=$cust_id', '_self')</script>";
        }
    }
}

function check_stock($cust_id) {
    global $con;
    $stock_result = mysqli_query($con, "SELECT a.productID, a.quantity, p.name, p.stock FROM addsToCart a INNER JOIN product p ON a.productID = p.productID WHERE a.customerID = $cust_id;");
    if (mysqli_num_rows($stock_result) > 0) {
        while ($row = mysqli_fetch_assoc($stock_result)) {
            if ($row['quantity'] > $row['stock']) return $row['name'];
        }
    }
    return true;
}

// Function for admin to view pending orders & Dispatch them
function viewPendingOrders($admin_id) {
    global $con;
    $order_result = mysqli_query($con, "SELECT * FROM `order` WHERE status = 'Confirmed' ORDER BY orderID DESC;");
    if (mysqli_num_rows($order_result) == 0) {
        echo "<div class='text-center py-5'><i class='fas fa-check-circle' style='font-size:2.5rem;color:#1A1A1A;'></i><p class='mt-3' style='color:#888;'>No pending orders right now.</p></div>";
    } else {
        ?>
        <div class="container my-3">
            <h4 class='text-center mb-4' style='font-family:Playfair Display,serif;color:#1A1A1A;'>Pending Orders</h4>
            <div class="table-responsive">
            <table class='table table-bordered align-middle'>
                <thead>
                    <tr>
                        <th>Order ID</th><th>Customer</th><th>Cost</th>
                        <th>Address</th><th>Placed On</th><th>Agent</th><th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($order_result)) {
                        $order_id = $row['orderID']; $order_location = $row['location'];
                        $order_price = $row['total_price']; $order_time = $row['time'];
                        $order_custID = $row['customerID']; $order_agentID = $row['agentID'];
                        $rc = mysqli_query($con, "SELECT * FROM customer WHERE customerID = $order_custID;");
                        $cust = mysqli_fetch_assoc($rc);
                        $cust_name = trim($cust['first_name'] . ' ' . $cust['last_name']);
                        $ra = mysqli_query($con, "SELECT * FROM deliveryAgent WHERE agentID = $order_agentID;");
                        $agent = mysqli_fetch_assoc($ra);
                        $agent_name = trim($agent['first_name'] . ' ' . $agent['last_name']);
                    ?>
                    <tr>
                        <td>#<?php echo $order_id; ?></td>
                        <td><?php echo $cust_name; ?></td>
                        <td>₹<?php echo $order_price; ?></td>
                        <td><?php echo $order_location; ?></td>
                        <td><?php echo $order_time; ?></td>
                        <td><?php echo $agent_name; ?></td>
                        <td>
                            <form action='index.php?admin_id=<?php echo $admin_id; ?>&dispatch_order&order_id=<?php echo $order_id; ?>' method="post">
                                <button type="submit" class="btn btn-pastel btn-sm" name="ship_order">Dispatch</button>
                            </form>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            </div>
        </div>
        <?php
    }
}

// Function for agent to view pending orders & deliver them
function viewDeliveringOrders($agent_id) {
    global $con;
    $result_confirmed = mysqli_query($con, "SELECT * FROM `order` WHERE status = 'Confirmed' AND agentID = '$agent_id' ORDER BY orderID DESC;");
    if (mysqli_num_rows($result_confirmed) != 0) {
        echo "<div class='text-center py-4'><i class='fas fa-store' style='font-size:2rem;color:#1A1A1A;'></i><p class='mt-2' style='color:#1A1A1A;'>You have a confirmed order — please go to the store and wait while it is packed.</p></div>";
    } else {
        $order_result = mysqli_query($con, "SELECT * FROM `order` WHERE status = 'Packed and Shipped' AND agentID = '$agent_id' ORDER BY orderID DESC;");
        if (mysqli_num_rows($order_result) == 0) {
            echo "<div class='text-center py-5'><i class='fas fa-check-circle' style='font-size:2.5rem;color:#1A1A1A;'></i><p class='mt-3' style='color:#888;'>No orders to deliver right now.</p></div>";
        } else {
            ?>
            <div class="container my-3">
                <h4 class='text-center mb-4' style='font-family:Playfair Display,serif;color:#1A1A1A;'>Orders to Deliver</h4>
                <div class="table-responsive">
                <table class='table table-bordered align-middle'>
                    <thead>
                        <tr>
                            <th>Order ID</th><th>Customer</th><th>Address</th>
                            <th>Placed On</th><th>Your Earning</th><th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($order_result)) {
                            $order_id = $row['orderID']; $order_location = $row['location'];
                            $order_time = $row['time']; $order_custID = $row['customerID'];
                            $order_agentPayment = $row['agentPayment'];
                            $rc = mysqli_query($con, "SELECT * FROM customer WHERE customerID = $order_custID;");
                            $cust = mysqli_fetch_assoc($rc);
                            $cust_name = trim($cust['first_name'] . ' ' . $cust['last_name']);
                        ?>
                        <tr>
                            <td>#<?php echo $order_id; ?></td>
                            <td><?php echo $cust_name; ?></td>
                            <td><?php echo $order_location; ?></td>
                            <td><?php echo $order_time; ?></td>
                            <td>₹<?php echo $order_agentPayment; ?></td>
                            <td>
                                <a href='deliver_order.php?agent_id=<?php echo $agent_id; ?>&order_id=<?php echo $order_id; ?>' class='btn btn-pastel btn-sm'>Deliver</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                </div>
            </div>
            <?php
        }
    }
}

// Function for agent to view history
function viewDeliveryHistory($agent_id) {
    global $con;
    $order_result = mysqli_query($con, "SELECT * FROM `order` WHERE status = 'Delivered' AND agentID = '$agent_id' ORDER BY orderID DESC;");
    if (mysqli_num_rows($order_result) == 0) {
        echo "<div class='text-center py-5'><i class='fas fa-history' style='font-size:2.5rem;color:#1A1A1A;'></i><p class='mt-3' style='color:#888;'>No delivery history yet.</p></div>";
    } else {
        ?>
        <div class="container my-3">
            <h4 class='text-center mb-4' style='font-family:Playfair Display,serif;color:#1A1A1A;'>Delivery History</h4>
            <div class="table-responsive">
            <table class='table table-bordered align-middle'>
                <thead>
                    <tr><th>Order ID</th><th>Customer</th><th>Address</th><th>Placed On</th><th>Earning</th></tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($order_result)) {
                        $rc = mysqli_query($con, "SELECT * FROM customer WHERE customerID = {$row['customerID']};");
                        $cust = mysqli_fetch_assoc($rc);
                        $cust_name = trim($cust['first_name'] . ' ' . $cust['last_name']);
                    ?>
                    <tr>
                        <td>#<?php echo $row['orderID']; ?></td>
                        <td><?php echo $cust_name; ?></td>
                        <td><?php echo $row['location']; ?></td>
                        <td><?php echo $row['time']; ?></td>
                        <td>₹<?php echo $row['agentPayment']; ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            </div>
        </div>
        <?php
    }
}
?>

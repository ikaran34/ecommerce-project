<?php
session_start();
include('includes/connect.php');
include('includes/db_helper.php');
include('includes/sanitize.php');

// Function to get IP address
function getIPAddress() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

$getIpAddress = getIPAddress();

// Remove cart items
if (isset($_POST['remove_item'])) {
    if (isset($_POST['remove_id'])) {
        $remove_id = (int)$_POST['remove_id'];
        $delete_query = "DELETE FROM `cart_details` WHERE product_id = ? AND ip_address = ?";
        $result = executeUpdate($con, $delete_query, [$remove_id, $getIpAddress], "is");
        if ($result) {
            echo "<script>alert('Item removed successfully');</script>";
            echo "<script>window.open('cart.php','_self');</script>";
        }
    }
}

// Update cart quantity
if (isset($_POST['update_cart'])) {
    if (isset($_POST['update_qty'])) {
        $quantities = $_POST['update_qty'];
        foreach ($quantities as $product_id => $quantity) {
            $product_id = (int)$product_id;
            $quantity = (int)$quantity;
            if ($quantity > 0) {
                $update_query = "UPDATE `cart_details` SET quantity = ? WHERE ip_address = ? AND product_id = ?";
                executeUpdate($con, $update_query, [$quantity, $getIpAddress, $product_id], "isi");
            }
        }
        echo "<script>alert('Cart updated successfully');</script>";
        echo "<script>window.open('cart.php','_self');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="./style.css">
</head>

<body>
    <!-- Navbar -->
    <?php include('./ui/nav.php') ?>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Shopping Cart</h2>
        
        <?php
        $cart_query = "SELECT * FROM `cart_details` WHERE ip_address = ?";
        $cart_result = executeQuery($con, $cart_query, [$getIpAddress], "s");
        
        if ($cart_result && mysqli_num_rows($cart_result) > 0) {
        ?>
        <form action="" method="post">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total_price = 0;
                    while ($cart_item = mysqli_fetch_assoc($cart_result)) {
                        $product_id = (int)$cart_item['product_id'];
                        $quantity = (int)$cart_item['quantity'];
                        
                        $product_query = "SELECT * FROM `products` WHERE product_id = ?";
                        $product_result = executeQuery($con, $product_query, [$product_id], "i");
                        
                        if ($product_result && $product_row = mysqli_fetch_assoc($product_result)) {
                            $product_title = escapeOutput($product_row['product_title']);
                            $product_price = (float)$product_row['product_price'];
                            $product_image = escapeOutput($product_row['product_image_one']);
                            $item_total = $product_price * $quantity;
                            $total_price += $item_total;
                    ?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="./admin/product_images/<?php echo $product_image; ?>" 
                                     alt="<?php echo $product_title; ?>" 
                                     class="img-thumbnail" style="width: 80px; height: 80px;">
                                <span class="ms-3"><?php echo $product_title; ?></span>
                            </div>
                        </td>
                        <td>$<?php echo number_format($product_price, 2); ?></td>
                        <td>
                            <input type="number" name="update_qty[<?php echo $product_id; ?>]" 
                                   value="<?php echo $quantity; ?>" min="1" class="form-control" style="width: 80px;">
                        </td>
                        <td>$<?php echo number_format($item_total, 2); ?></td>
                        <td>
                            <button type="submit" name="remove_item" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i> Remove
                            </button>
                            <input type="hidden" name="remove_id" value="<?php echo $product_id; ?>">
                        </td>
                    </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr class="table-active">
                        <td colspan="3" class="text-end"><strong>Grand Total:</strong></td>
                        <td colspan="2"><strong>$<?php echo number_format($total_price, 2); ?></strong></td>
                    </tr>
                </tfoot>
            </table>
            
            <div class="d-flex justify-content-between">
                <button type="submit" name="update_cart" class="btn btn-warning">
                    <i class="fas fa-sync-alt"></i> Update Cart
                </button>
                <a href="products.php" class="btn btn-primary">
                    <i class="fas fa-shopping-bag"></i> Continue Shopping
                </a>
                <a href="users_area/checkout.php" class="btn btn-success">
                    <i class="fas fa-credit-card"></i> Proceed to Checkout
                </a>
            </div>
        </form>
        <?php
        } else {
            echo '<div class="alert alert-info text-center">
                    <h4>Your cart is empty!</h4>
                    <p>Add some products to your cart first.</p>
                    <a href="products.php" class="btn btn-primary">Browse Products</a>
                  </div>';
        }
        ?>
    </div>

    <!-- Footer -->
    <?php include('./ui/footer.php') ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
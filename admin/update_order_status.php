<?php
session_start();
include('../includes/connect.php');
include('../includes/db_helper.php');
include('../includes/sanitize.php');

// Check if user is admin
if (!isset($_SESSION['admin_username'])) {
    header('Location: admin_login.php');
    exit();
}

$message = '';

// Update order status if form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'], $_POST['new_status'])) {
    $order_id = (int)$_POST['order_id'];
    $new_status = $_POST['new_status'];
    
    // Validate status
    $allowed_statuses = ['pending', 'confirmed', 'payment_pending', 'payment_received', 'delivered', 'canceled'];
    if (!in_array($new_status, $allowed_statuses)) {
        $message = '<div class="alert alert-danger">Invalid status!</div>';
    } else {
        // Get current status
        $sql = "SELECT order_status FROM user_orders WHERE order_id = ?";
        $result = executeQuery($con, $sql, [$order_id], "i");
        
        if ($result && $row = mysqli_fetch_assoc($result)) {
            $old_status = $row['order_status'];
            
            // Update order status
            $update_sql = "UPDATE user_orders SET order_status = ? WHERE order_id = ?";
            $success = executeUpdate($con, $update_sql, [$new_status, $order_id], "si");
            
            if ($success) {
                $message = '<div class="alert alert-success">Order status updated from ' . escapeOutput($old_status) . ' to ' . escapeOutput($new_status) . '!</div>';
                
                // Log status change
                $log_sql = "INSERT INTO order_status_history (order_id, old_status, new_status, updated_by) 
                           VALUES (?, ?, ?, ?)";
                executeUpdate($con, $log_sql, [$order_id, $old_status, $new_status, $_SESSION['admin_id']], "isss");
            } else {
                $message = '<div class="alert alert-danger">Failed to update order status!</div>';
            }
        } else {
            $message = '<div class="alert alert-danger">Order not found!</div>';
        }
    }
}

// Get all orders
$orders_sql = "SELECT o.*, u.username, u.user_email 
               FROM user_orders o 
               JOIN user_table u ON o.user_id = u.user_id 
               ORDER BY o.order_date DESC";
$orders_result = executeQuery($con, $orders_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Order Status</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }
        .status-pending { background-color: #ffc107; color: #000; }
        .status-confirmed { background-color: #17a2b8; color: #fff; }
        .status-payment_pending { background-color: #6c757d; color: #fff; }
        .status-payment_received { background-color: #28a745; color: #fff; }
        .status-delivered { background-color: #007bff; color: #fff; }
        .status-canceled { background-color: #dc3545; color: #fff; }
    </style>
</head>
<body>
    <?php include('navbar.php'); ?>
    
    <div class="container mt-4">
        <h2 class="mb-4">Manage Order Status</h2>
        
        <?php echo $message; ?>
        
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">All Orders</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Amount Due</th>
                                <th>Invoice No</th>
                                <th>Date</th>
                                <th>Current Status</th>
                                <th>Update Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($orders_result && mysqli_num_rows($orders_result) > 0) {
                                while ($order = mysqli_fetch_assoc($orders_result)) {
                                    $status_class = 'status-' . $order['order_status'];
                            ?>
                            <tr>
                                <td>#<?php echo escapeOutput($order['order_id']); ?></td>
                                <td>
                                    <?php echo escapeOutput($order['username']); ?><br>
                                    <small class="text-muted"><?php echo escapeOutput($order['user_email']); ?></small>
                                </td>
                                <td>$<?php echo number_format($order['amount_due'], 2); ?></td>
                                <td><?php echo escapeOutput($order['invoice_number']); ?></td>
                                <td><?php echo date('M d, Y', strtotime($order['order_date'])); ?></td>
                                <td>
                                    <span class="status-badge <?php echo $status_class; ?>">
                                        <?php echo strtoupper(str_replace('_', ' ', $order['order_status'])); ?>
                                    </span>
                                </td>
                                <td>
                                    <form method="POST" class="d-inline">
                                        <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                                        <select name="new_status" class="form-select form-select-sm" onchange="this.form.submit()">
                                            <option value="pending" <?php echo $order['order_status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                            <option value="confirmed" <?php echo $order['order_status'] == 'confirmed' ? 'selected' : ''; ?>>Confirmed</option>
                                            <option value="payment_pending" <?php echo $order['order_status'] == 'payment_pending' ? 'selected' : ''; ?>>Payment Pending</option>
                                            <option value="payment_received" <?php echo $order['order_status'] == 'payment_received' ? 'selected' : ''; ?>>Payment Received</option>
                                            <option value="delivered" <?php echo $order['order_status'] == 'delivered' ? 'selected' : ''; ?>>Delivered</option>
                                            <option value="canceled" <?php echo $order['order_status'] == 'canceled' ? 'selected' : ''; ?>>Canceled</option>
                                        </select>
                                    </form>
                                </td>
                                <td>
                                    <a href="view_order.php?id=<?php echo $order['order_id']; ?>" class="btn btn-sm btn-info">
                                        View Details
                                    </a>
                                </td>
                            </tr>
                            <?php
                                }
                            } else {
                                echo '<tr><td colspan="8" class="text-center">No orders found.</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="mt-4">
            <a href="list_orders.php" class="btn btn-secondary">Back to Orders List</a>
            <a href="admin_dashboard.php" class="btn btn-primary">Dashboard</a>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
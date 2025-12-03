<?php
// api/orders.php - REST API endpoint for orders
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../includes/connect.php';
require_once '../includes/db_helper.php';
require_once '../includes/sanitize.php';

session_start();
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        // Get orders - admin sees all, users see their own
        if (isset($_SESSION['admin_username'])) {
            // Admin: get all orders
            $sql = "SELECT o.*, u.username, u.user_email 
                    FROM user_orders o 
                    JOIN user_table u ON o.user_id = u.user_id 
                    ORDER BY o.order_date DESC";
            $result = executeQuery($con, $sql);
        } elseif (isset($_SESSION['username'])) {
            // User: get their own orders
            $user_id = (int)$_SESSION['user_id'];
            $sql = "SELECT * FROM user_orders WHERE user_id = ? ORDER BY order_date DESC";
            $result = executeQuery($con, $sql, [$user_id], "i");
        } else {
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            http_response_code(401);
            exit();
        }
        
        $orders = [];
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $row = array_map('escapeOutput', $row);
                $orders[] = $row;
            }
            echo json_encode(['success' => true, 'data' => $orders, 'count' => count($orders)]);
        } else {
            echo json_encode(['success' => false, 'message' => 'No orders found']);
        }
        break;
        
    case 'POST':
        // Place new order
        if (!isset($_SESSION['username'])) {
            echo json_encode(['success' => false, 'message' => 'Login required']);
            http_response_code(401);
            exit();
        }
        
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (isset($data['amount_due'], $data['invoice_number'], $data['total_products'])) {
            $sql = "INSERT INTO user_orders (user_id, amount_due, invoice_number, total_products, order_date, order_status) 
                    VALUES (?, ?, ?, ?, NOW(), 'pending')";
            
            $params = [
                (int)$_SESSION['user_id'],
                (float)$data['amount_due'],
                escapeOutput($data['invoice_number']),
                (int)$data['total_products']
            ];
            
            $success = executeUpdate($con, $sql, $params, "idsi");
            
            if ($success) {
                echo json_encode(['success' => true, 'order_id' => getLastInsertId($con)]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to create order']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Missing required fields']);
        }
        break;
        
    default:
        echo json_encode(['success' => false, 'message' => 'Method not allowed']);
        http_response_code(405);
}
?>
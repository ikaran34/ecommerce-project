<?php
// api/products.php - REST API endpoint for products
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../includes/connect.php';
require_once '../includes/db_helper.php';
require_once '../includes/sanitize.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        // Get all products or single product
        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];
            $sql = "SELECT * FROM products WHERE product_id = ?";
            $result = executeQuery($con, $sql, [$id], "i");
            
            if ($result && $row = mysqli_fetch_assoc($result)) {
                // Sanitize output
                $row = array_map('escapeOutput', $row);
                echo json_encode(['success' => true, 'data' => $row]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Product not found']);
            }
        } else {
            // Get all products
            $sql = "SELECT * FROM products";
            $result = executeQuery($con, $sql);
            
            $products = [];
            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $row = array_map('escapeOutput', $row);
                    $products[] = $row;
                }
                echo json_encode(['success' => true, 'data' => $products, 'count' => count($products)]);
            } else {
                echo json_encode(['success' => false, 'message' => 'No products found']);
            }
        }
        break;
        
    case 'POST':
        // Create new product (admin only)
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (isset($data['product_title'], $data['product_price'])) {
            $sql = "INSERT INTO products (product_title, product_description, product_keywords, category_id, brand_id, product_image_one, product_image_two, product_image_three, product_price) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            $params = [
                escapeOutput($data['product_title']),
                escapeOutput($data['product_description'] ?? ''),
                escapeOutput($data['product_keywords'] ?? ''),
                (int)($data['category_id'] ?? 1),
                (int)($data['brand_id'] ?? 1),
                escapeOutput($data['product_image_one'] ?? ''),
                escapeOutput($data['product_image_two'] ?? ''),
                escapeOutput($data['product_image_three'] ?? ''),
                (float)$data['product_price']
            ];
            
            $success = executeUpdate($con, $sql, $params, "sssiisssd");
            
            if ($success) {
                echo json_encode(['success' => true, 'id' => getLastInsertId($con)]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to create product']);
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
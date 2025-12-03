<?php
session_start();

// Use absolute paths for includes
$base_dir = dirname(__DIR__);
require_once $base_dir . '/includes/connect.php';
require_once $base_dir . '/includes/db_helper.php';
require_once $base_dir . '/includes/sanitize.php';

if (isset($_POST['admin_login'])) {
    $admin_username = sanitizeInput($con, $_POST['admin_username']);
    $admin_password = $_POST['admin_password'];
    
    // Check if username exists
    $select_query = "SELECT * FROM `admin_table` WHERE admin_name = ?";
    $result = executeQuery($con, $select_query, [$admin_username], "s");
    
    if ($result && mysqli_num_rows($result) > 0) {
        $admin_data = mysqli_fetch_assoc($result);
        
        // Verify password
        if (password_verify($admin_password, $admin_data['admin_password'])) {
            $_SESSION['admin_username'] = $admin_username;
            $_SESSION['admin_id'] = $admin_data['admin_id'];
            echo "<script>alert('Login successful!');</script>";
            echo "<script>window.open('index.php','_self');</script>";
        } else {
            echo "<script>alert('Invalid credentials!');</script>";
        }
    } else {
        echo "<script>alert('Invalid credentials!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
            width: 100%;
            max-width: 400px;
        }
        .login-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .login-body {
            padding: 30px;
        }
        .form-control {
            padding: 12px 15px;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            transition: all 0.3s;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            padding: 12px;
            border-radius: 8px;
            width: 100%;
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <h2><i class="fas fa-lock"></i> Admin Login</h2>
            <p class="mb-0">Access the admin dashboard</p>
        </div>
        <div class="login-body">
            <form action="" method="post">
                <div class="mb-3">
                    <label for="admin_username" class="form-label">
                        <i class="fas fa-user"></i> Username
                    </label>
                    <input type="text" class="form-control" id="admin_username" 
                           name="admin_username" placeholder="Enter username" required>
                </div>
                <div class="mb-4">
                    <label for="admin_password" class="form-label">
                        <i class="fas fa-key"></i> Password
                    </label>
                    <input type="password" class="form-control" id="admin_password" 
                           name="admin_password" placeholder="Enter password" required>
                </div>
                <button type="submit" name="admin_login" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i> Login
                </button>
            </form>
            
            <div class="mt-4 text-center">
                <a href="../index.php" class="text-decoration-none">
                    <i class="fas fa-home"></i> Back to Home
                </a>
                <span class="mx-2">|</span>
                <a href="admin_resgistration.php" class="text-decoration-none">
                    <i class="fas fa-user-plus"></i> Register Admin
                </a>
            </div>
            
            <?php
            // Display any error messages
            if (isset($error_message)) {
                echo '<div class="alert alert-danger mt-3">' . escapeOutput($error_message) . '</div>';
            }
            ?>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
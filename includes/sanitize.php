<?php
// includes/sanitize.php - Output escaping for XSS protection

/**
 * Escape HTML output to prevent XSS
 */
function escapeOutput($string) {
    return htmlspecialchars($string, ENT_QUOTES | ENT_HTML5, 'UTF-8');
}

/**
 * Validate and sanitize file upload
 */
function validateFileUpload($file, $allowed_types = ['image/jpeg', 'image/png', 'image/gif'], $max_size = 2097152) {
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return [false, "Upload error: " . $file['error']];
    }
    
    if ($file['size'] > $max_size) {
        return [false, "File too large. Maximum size: " . ($max_size/1024/1024) . "MB"];
    }
    
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime_type = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);
    
    if (!in_array($mime_type, $allowed_types)) {
        return [false, "Invalid file type. Allowed: " . implode(', ', $allowed_types)];
    }
    
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $safe_filename = uniqid() . '_' . preg_replace('/[^a-zA-Z0-9\.]/', '_', basename($file['name']));
    
    return [true, "File valid", $safe_filename];
}

/**
 * Validate email address
 */
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Validate password strength
 */
function validatePassword($password) {
    if (strlen($password) < 8) {
        return [false, "Password must be at least 8 characters"];
    }
    
    if (!preg_match('/[A-Z]/', $password)) {
        return [false, "Password must contain at least one uppercase letter"];
    }
    
    if (!preg_match('/[a-z]/', $password)) {
        return [false, "Password must contain at least one lowercase letter"];
    }
    
    if (!preg_match('/[0-9]/', $password)) {
        return [false, "Password must contain at least one number"];
    }
    
    return [true, "Password is strong"];
}
?>
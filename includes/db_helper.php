<?php
// includes/db_helper.php - Secure database functions with prepared statements

/**
 * Execute SELECT query with prepared statements
 */
function executeQuery($con, $sql, $params = [], $types = "") {
    $stmt = $con->prepare($sql);
    if (!$stmt) {
        error_log("SQL Prepare failed: " . $con->error);
        return false;
    }
    
    if (!empty($params)) {
        if (count($params) != strlen($types)) {
            error_log("Parameter count mismatch");
            return false;
        }
        $stmt->bind_param($types, ...$params);
    }
    
    if (!$stmt->execute()) {
        error_log("SQL Execute failed: " . $stmt->error);
        return false;
    }
    
    return $stmt->get_result();
}

/**
 * Execute INSERT/UPDATE/DELETE query with prepared statements
 */
function executeUpdate($con, $sql, $params = [], $types = "") {
    $stmt = $con->prepare($sql);
    if (!$stmt) {
        error_log("SQL Prepare failed: " . $con->error);
        return false;
    }
    
    if (!empty($params)) {
        if (count($params) != strlen($types)) {
            error_log("Parameter count mismatch");
            return false;
        }
        $stmt->bind_param($types, ...$params);
    }
    
    return $stmt->execute();
}

/**
 * Get last insert ID
 */
function getLastInsertId($con) {
    return $con->insert_id;
}

/**
 * Sanitize input for SQL
 */
function sanitizeInput($con, $input) {
    return mysqli_real_escape_string($con, $input);
}
?>
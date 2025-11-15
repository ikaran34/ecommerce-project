<?php
$con = new mysqli('localhost', 'root', '', 'ecommerce_1'); // adjust DB name if different

if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>

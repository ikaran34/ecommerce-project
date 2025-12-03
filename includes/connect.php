<?php
// includes/connect.php - Database connection

$con = mysqli_connect("localhost", "root", "", "ecommerce_1");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
<?php
// connection.php

require_once 'db.php';  // Include db.php where the variables are defined

// Use the same variable names as in db.php
$conn = new mysqli($host, $user, $pass, $db);  // Use $host, $user, $pass, and $db

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>

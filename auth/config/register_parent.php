<?php
// register_parent.php

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "adoption";

// Try to connect to the database
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    header("Location: ../index.php?message=Database connection failed&type=error");
    exit();
}

// Get and validate form data
$user_username = $_POST['username'];
$user_password = $_POST['password'];
$user_email = $_POST['email'];
$user_phone = $_POST['phone_number'];

// Check for empty required fields
if (empty($user_username) || empty($user_password) || empty($user_email)) {
    header("Location: ../index.php?message=All required fields must be filled&type=error");
    exit();
}

// Hash the password for security
$hashed_password = password_hash($user_password, PASSWORD_BCRYPT);
$parent_role_id = 2; // Assuming '2' is the RoleID for "Parent" from the role table

// Insert the new user using a prepared statement
$sql = "INSERT INTO users (username, password, role, email, phone_number) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssiss", $user_username, $hashed_password, $parent_role_id, $user_email, $user_phone);

if ($stmt->execute()) {
    // Redirect to login page with a success message
    header("Location: ../index.php?message=Registration successful, please login&type=success");
} else {
    // Redirect back to registration form with an error message
    $error_message = "Error: " . $stmt->error;
    header("Location: ../index.php?message=" . urlencode($error_message) . "&type=error");
}

// Close connections
$stmt->close();
$conn->close();
?>

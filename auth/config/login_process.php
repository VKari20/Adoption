<?php
// login_process.php

session_start();

// Database connection details
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "adoption";

// Connect to the database
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check for connection error
if ($conn->connect_error) {
    header("Location: ../index.php?message=Database connection failed&type=error");
    exit();
}

// Get form data
$email = $_POST['email'];
$password = $_POST['password'];

// Validate form input
if (empty($email) || empty($password)) {
    header("Location: ../index.php?message=Email and password are required&type=error");
    exit();
}

// Check if the user exists and fetch details
$sql = "SELECT user_id, username, password, role FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    // Verify the password
    if (password_verify($password, $user['password'])) {
        // Start the session and save user_id and role
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['role'] = $user['role'];
        
        // Check if the user is a parent
        if ($user['role'] == 2) {
            // Check if the user has a parent_id in prospective_parents
            $parent_check_sql = "SELECT parent_id FROM prospective_parents WHERE user_id = ?";
            $parent_check_stmt = $conn->prepare($parent_check_sql);
            $parent_check_stmt->bind_param("i", $user['user_id']);
            $parent_check_stmt->execute();
            $parent_check_result = $parent_check_stmt->get_result();

            if ($parent_check_result->num_rows > 0) {
                // Parent ID exists, add it to session
                $parent_data = $parent_check_result->fetch_assoc();
                $_SESSION['parent_id'] = $parent_data['parent_id'];

                // Redirect to the dashboard or homepage
                header("Location: ../../DASHBOARD/User/index.php?message=Login successful&type=success");
                exit();
            } else {
                // Parent ID does not exist, redirect to parent_id.php
                header("Location: ../../DASHBOARD/User/parent_id.php");
                exit();
            }
        } else {
            // Redirect non-parent roles to dashboard
            header("Location: ../../DASHBOARD/User/index.php?message=Login successful&type=success");
            exit();
        }
    } else {
        // Password doesn't match
        header("Location: ../index.php?message=Incorrect password&type=error");
        exit();
    }
} else {
    // Email not found
    header("Location: ../index.php?message=Email not found&type=error");
    exit();
}

// Close the database connection
$stmt->close();
$conn->close();
?>

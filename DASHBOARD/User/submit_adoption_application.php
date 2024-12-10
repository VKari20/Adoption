<?php
session_start();

require_once 'connection.php'; // Import the database connection

// Check if the user is logged in and is a prospective parent
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'prospective parent') {
    header("Location: ../index.php?message=Unauthorized access&type=error");
    exit();
}

// Get form data
$parent_id = $_SESSION['parent_id'];
$child_id = isset($_POST['child_id']) ? $_POST['child_id'] : null;
$additional_notes = isset($_POST['additional_notes']) ? $_POST['additional_notes'] : '';

// Check if an application has already been submitted for this parent
$sql_check = "SELECT application_id FROM adoption_applications WHERE parent_id = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("i", $parent_id);
$stmt_check->execute();
$stmt_check->store_result();

if ($stmt_check->num_rows > 0) {
    // Application already exists
    $_SESSION['form_submitted'] = 'You already have an existing application.';
    header("Location: adoption_application.php");
    exit();
}

// Validate required fields
if (empty($child_id) || empty($additional_notes)) {
    $_SESSION['form_submitted'] = 'Please complete all required fields.';
    header("Location: adoption_application.php");
    exit();
}

// Insert new application into the database
$sql_insert = "INSERT INTO adoption_applications (parent_id, child_id, application_date, application_status, review_notes) VALUES (?, ?, CURDATE(), 'pending', ?)";
$stmt_insert = $conn->prepare($sql_insert);
$stmt_insert->bind_param("iis", $parent_id, $child_id, $additional_notes);

// Execute the query
if ($stmt_insert->execute()) {
    // Set session flag to indicate successful submission
    $_SESSION['form_submitted'] = 'Application submitted successfully!';
    header("Location: adoption_application.php");
} else {
    // Failure to submit application
    $_SESSION['form_submitted'] = 'Failed to submit application. Please try again.';
    header("Location: adoption_application.php");
}

// Close statements and connection
$stmt_check->close();
$stmt_insert->close();
$conn->close();
?>

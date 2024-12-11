<?php
// Start the session and connect to the database
session_start();
require_once 'connection.php'; // Include your database connection file

// Check if 'id' and 'action' are set in the query string
if (isset($_GET['id']) && isset($_GET['action'])) {
    $parent_id = $_GET['id'];
    $action = $_GET['action']; // 'accept' or 'reject'

    // Validate action input (for security purposes)
    if ($action !== 'accept' && $action !== 'reject') {
        die("Invalid action");
    }

    // Prepare SQL to update the status of the request
    $status = ($action === 'accept') ? 'accepted' : 'rejected';

    $sql = "UPDATE adoption_requests SET status = ? WHERE parent_id = ?";
    
    // Prepare and bind the parameters
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error in preparing statement: " . $conn->error);
    }

    $stmt->bind_param("si", $status, $parent_id); // 's' for string, 'i' for integer
    $stmt->execute();

    // Check if the query was successful
    if ($stmt->error) {
        die("Error executing query: " . $stmt->error);
    }

    // Redirect to the accepted requests page after updating the status
    header("Location: accepted_requests.php");
    exit();
} else {
    die("Invalid request");
}

// Close the database connection
$stmt->close();
$conn->close();
?>

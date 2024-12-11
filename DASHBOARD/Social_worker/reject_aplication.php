<?php
// Start session and connect to the database
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "adoption";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the `id` parameter is present
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Update the application status to 'Rejected'
    $sql = "UPDATE home_study_applications SET status='Rejected' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        // Redirect back to the main page
        header("Location: home_study_approval.php");
        exit();
    } else {
        die("Error updating record: " . $conn->error);
    }
} else {
    die("Invalid request.");
}

// Close the database connection
$conn->close();
?>

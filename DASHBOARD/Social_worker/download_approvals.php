<?php
// Start session and connect to the database
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "adoption";

// Database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from the home_study_applications table
$sql = "SELECT id, full_name, occupation, marital_status, status FROM home_study_applications";
$result = $conn->query($sql);

if (!$result) {
    die("Error executing query: " . $conn->error);
}

// Set the headers to indicate a file download
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="home_study_applications.csv"');

// Open a file handle for output
$output = fopen('php://output', 'w');

// Write the column headers
fputcsv($output, ['ID', 'Full Name', 'Occupation', 'Marital Status', 'Status']);

// Write the data rows
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, [$row['id'], $row['full_name'], $row['occupation'], $row['marital_status'], $row['status']]);
    }
}

// Close the file handle
fclose($output);

// Close the database connection
$conn->close();
exit();
?>

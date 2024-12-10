<?php
// Start session and connect to the database
session_start();

require_once 'connection.php'; // Import the database connection

// Set the headers to download the file as CSV
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=adoption_applications.csv');

// Open output stream
$output = fopen('php://output', 'w');

// Output column headings
fputcsv($output, ['Application ID', 'Parent ID', 'Application Date', 'Status', 'Review Notes', 'Final Decision Date']);

// Fetch data from the database
$sql = "SELECT application_id, parent_id, application_date, application_status, review_notes, final_decision_date FROM adoption_applications";
$result = $conn->query($sql);

// Check if there are records
if ($result->num_rows > 0) {
    // Output each row as a CSV line
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, $row);
    }
} else {
    fputcsv($output, ['No data available']);
}

// Close the database connection
$conn->close();

// Close output stream
fclose($output);
exit();
?>

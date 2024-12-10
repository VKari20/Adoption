<?php
// Database connection details
require_once 'connection.php'; // Import the database connection

// Set headers to force download
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=adoption_requests_report.csv');

// Open a file pointer connected to the output stream
$output = fopen('php://output', 'w');

// Output the column headers
fputcsv($output, array('ID', 'Adoption Request Number', 'Adopter Name', 'Adopter Email', 'Contact Number', 'Status', 'Adoption Date'));

// Fetch the data
$sql = "SELECT 
            id, 
            adoption_request_number, 
            adopter_name, 
            adopter_email, 
            contact_number, 
            status, 
            adoption_date
        FROM adoption_requests";

$result = $conn->query($sql);

// Check if there are rows in the result
if ($result->num_rows > 0) {
    // Output each row of the data to the CSV
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, $row);
    }
} else {
    // If no data found, write a message or an empty row
    fputcsv($output, array('No data available'));
}

// Close the file pointer and database connection
fclose($output);
$conn->close();
exit();
?>

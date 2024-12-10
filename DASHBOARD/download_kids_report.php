<?php
require_once 'connection.php'; // Import the database connection
// Set headers to force download
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=kids_report.csv');

// Open a file pointer connected to the output stream
$output = fopen('php://output', 'w');

// Output the column headers
fputcsv($output, array('ID', 'Full Name', 'Date of Birth', 'Gender', 'Education Level', 'Orphanage', 'Status', 'Blood Group'));

// Fetch the data
$sql = "SELECT 
            c.child_id, 
            c.full_name, 
            c.date_of_birth, 
            c.gender, 
            c.education_level, 
            o.orphanage_name AS current_orphanage, 
            c.status,
            c.blood_group
        FROM children AS c
        LEFT JOIN orphanages AS o ON c.current_orphanage_id = o.orphanage_id";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output each row of the data
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, $row);
    }
} else {
    // If no data, output an empty row or message
    fputcsv($output, array('No data available'));
}

// Close file pointer and database connection
fclose($output);
$conn->close();
exit();
?>

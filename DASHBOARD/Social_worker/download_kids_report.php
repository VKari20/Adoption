<?php
// Start session and connect to the database
session_start();

require_once 'connection.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all children data
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

// Check if records are available
if ($result->num_rows > 0) {
    // Set headers for file download
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="kids_report.csv"');

    // Open output stream
    $output = fopen('php://output', 'w');

    // Write the header row to the CSV file
    fputcsv($output, [
        'Child ID',
        'Full Name',
        'Date of Birth',
        'Gender',
        'Education Level',
        'Current Orphanage',
        'Blood Group',
        'Status'
    ]);

    // Write data rows to the CSV file
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, [
            $row['child_id'],
            $row['full_name'],
            $row['date_of_birth'],
            $row['gender'],
            $row['education_level'],
            $row['current_orphanage'],
            $row['blood_group'],
            $row['status']
        ]);
    }

    // Close the output stream
    fclose($output);
} else {
    echo "No data available to download.";
}

$conn->close();
?>

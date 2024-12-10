<?php
require_once 'connection.php'; // Import the database connection

header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename=prospective_parents_report.csv');

// Open output stream
$output = fopen('php://output', 'w');

// Write the CSV column headers
fputcsv($output, ['#', 'Full Name', 'Home Address', 'Occupation', 'Marital Status', 'Home Study Status', 'Preferences', 'Status']);

// Query to fetch data from the database
$sql = "SELECT full_name, home_address, occupation, marital_status, home_study_status, preferences, status FROM prospective_parents";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $count = 1;
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, [
            $count,
            $row['full_name'],
            $row['home_address'],
            $row['occupation'],
            $row['marital_status'],
            $row['home_study_status'],
            $row['preferences'],
            $row['status']
        ]);
        $count++;
    }
} else {
    fputcsv($output, ['No data available']);
}

// Close output stream
fclose($output);
exit;
?>

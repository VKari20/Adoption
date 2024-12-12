<?php
require_once 'connection.php';

// Fetch successful adoptions data
$adoptions_query = "
    SELECT 
        m.match_id,
        p.full_name AS parent_name,
        p.home_address AS parent_address,
        c.full_name AS child_name,
        c.date_of_birth AS child_dob,
        c.disability AS child_special_needs,
        m.date_assigned AS adoption_date
    FROM 
        matches m
    INNER JOIN 
        prospective_parents p ON m.parent_id = p.parent_id
    INNER JOIN 
        children c ON m.child_id = c.child_id
    ORDER BY 
        m.date_assigned DESC";
$adoptions_result = $conn->query($adoptions_query);

if (!$adoptions_result) {
    die("Error fetching adoptions: " . $conn->error);
}

// Create a file pointer
$output = fopen('php://output', 'w');

// Set the filename for the download
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="adoption_report.csv"');

// Write the column headers to the CSV
fputcsv($output, ['Match ID', 'Parent Name', 'Parent Address', 'Child Name', 'Child Date of Birth', 'Special Needs', 'Adoption Date']);

// Fetch and write each row of data to the CSV
while ($adoption = $adoptions_result->fetch_assoc()) {
    // Format the data
    $adoption_data = [
        $adoption['match_id'],
        $adoption['parent_name'],
        $adoption['parent_address'],
        $adoption['child_name'],
        $adoption['child_dob'],
        $adoption['child_special_needs'] === 'yes' ? 'Yes' : 'No',
        $adoption['adoption_date']
    ];

    fputcsv($output, $adoption_data);
}

// Close the file pointer
fclose($output);

// Close the database connection
$conn->close();
exit();

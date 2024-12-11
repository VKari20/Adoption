<?php
// Database connection
$host = 'localhost';
$dbname = 'adoption';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Fetch all follow-up records
$stmt = $pdo->query("SELECT * FROM post_adoption_followup");
$followups = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Set headers for CSV download
header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename="post_adoption_followup.csv"');

// Open the output stream
$output = fopen('php://output', 'w');

// Write the header row
fputcsv($output, ['Follow-Up ID', 'Child ID', 'Parent ID', 'Follow-Up Date', 'Status', 'Notes', 'Next Follow-Up Date']);

// Write the data rows
foreach ($followups as $followup) {
    fputcsv($output, [
        $followup['followup_id'],
        $followup['child_id'],
        $followup['parent_id'],
        $followup['followup_date'],
        $followup['followup_status'],
        $followup['followup_notes'],
        $followup['next_followup_date']
    ]);
}

// Close the output stream
fclose($output);
exit;
?>

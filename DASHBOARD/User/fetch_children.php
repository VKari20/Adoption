<?php
require_once 'connection.php'; // Import the database connection

header('Content-Type: application/json');

$query = "SELECT * FROM children WHERE status != 'adopted'"; // Show only those who are not fully adopted
$result = $conn->query($query);

$children = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $children[] = $row;
    }
}

echo json_encode($children);
$conn->close();
?>

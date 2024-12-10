<?php
require_once 'connection.php'; // Import the database connection

if(isset($_POST['child_id'])) {
    $childId = $_POST['child_id'];

    $sql = "DELETE FROM children WHERE child_id = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $childId);
        if ($stmt->execute()) {
            echo 'success';
        } else {
            echo 'Error deleting record: ' . $stmt->error;
        }
    } else {
        echo 'SQL Error: ' . $conn->error;
    }

    $conn->close();
}
?>

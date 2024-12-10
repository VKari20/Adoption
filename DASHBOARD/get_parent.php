<?php
require_once 'connection.php'; // Import the database connection

if (isset($_POST['parent_id'])) {
    $parent_id = $_POST['parent_id'];
    $sql = "SELECT * FROM prospective_parents WHERE parent_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $parent_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $parent = $result->fetch_assoc();
    echo json_encode($parent);
}

$conn->close();
?>

<?php
require_once 'connection.php'; // Import the database connection

if(isset($_POST['child_id'])) {
    $childId = $_POST['child_id'];
    $sql = "SELECT * FROM children WHERE child_id = ?";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $childId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $child = $result->fetch_assoc();
            echo json_encode($child);
        } else {
            echo json_encode(['error' => 'Child not found']);
        }
    } else {
        echo json_encode(['error' => 'SQL Error']);
    }
    $conn->close();
}
?>

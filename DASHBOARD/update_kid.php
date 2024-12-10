<?php
require_once 'connection.php'; // Import the database connection

if(isset($_POST['child_id'])) {
    $childId = $_POST['child_id'];
    $fullName = $_POST['full_name'];
    $dateOfBirth = $_POST['date_of_birth'];
    $educationLevel = $_POST['education_level'];
    $gender = $_POST['gender'];
    $status = $_POST['status'];
    $bloodGroup = $_POST['blood_group'];

    $sql = "UPDATE children SET full_name = ?, date_of_birth = ?, education_level = ?, gender = ?, status = ?, blood_group = ? WHERE child_id = ?";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssssssi", $fullName, $dateOfBirth, $educationLevel, $gender, $status, $bloodGroup, $childId);
        if ($stmt->execute()) {
            echo 'success';
        } else {
            echo 'Error updating record: ' . $stmt->error;
        }
    } else {
        echo 'SQL Error: ' . $conn->error;
    }

    $conn->close();
}
?>

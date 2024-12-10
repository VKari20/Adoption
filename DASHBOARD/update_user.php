<?php
require_once 'connection.php'; // Import the database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    $user_id = (int)$_POST['user_id'];
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone_number = $conn->real_escape_string($_POST['phone_number']);
    $role = $conn->real_escape_string($_POST['role']);

    $sql = "UPDATE users SET username='$username', email='$email', phone_number='$phone_number', role='$role' WHERE user_id=$user_id";

    if ($conn->query($sql) === TRUE) {
        echo "success";
    } else {
        echo "Error: " . $conn->error;
    }
}
$conn->close();
?>

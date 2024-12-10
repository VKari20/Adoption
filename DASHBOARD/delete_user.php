<?php
require_once 'connection.php'; // Import the database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];
    $sql = "DELETE FROM users WHERE user_id = $user_id";

    if ($conn->query($sql) === TRUE) {
        echo "success";
    } else {
        echo "error";
    }
}
$conn->close();
?>

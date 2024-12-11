<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "adoption";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['child_id'])) {
    $child_id = intval($_POST['child_id']);

    $sql = "SELECT 
                c.child_id, 
                c.full_name, 
                c.date_of_birth, 
                c.gender, 
                c.education_level, 
                o.orphanage_name AS current_orphanage, 
                c.status,
                c.blood_group
            FROM children AS c
            LEFT JOIN orphanages AS o ON c.current_orphanage_id = o.orphanage_id
            WHERE c.child_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $child_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode($result->fetch_assoc());
    } else {
        echo json_encode(["error" => "Child not found."]);
    }
    $stmt->close();
}
$conn->close();
?>

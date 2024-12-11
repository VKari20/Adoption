<?php
session_start();
require_once 'connection.php'; // Database connection

// Check if parent_id is set in the session
if (!isset($_SESSION['parent_id'])) {
    die("Error: No parent ID found. Please log in again.");
}

$parent_id = $_SESSION['parent_id'];

// Check if the application has already been submitted
$sql = "SELECT status FROM home_study_applications WHERE parent_id = ? LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $parent_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if ($row['status'] === 'submitted') {
        echo "<div style='text-align: center; margin-top: 50px;'>
                <h2>Thank You!</h2>
                <p>Your Home Study Application has already been submitted.</p>
                <a href='index.php' style='text-decoration: none; color: white; background-color: #4caf50; padding: 10px 20px; border-radius: 5px;'>Back to Dashboard</a>
              </div>";
        exit;
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data with checks
    $full_name = $_POST['full_name'] ?? '';
    $home_address = $_POST['home_address'] ?? '';
    $occupation = $_POST['occupation'] ?? '';
    $marital_status = $_POST['marital_status'] ?? '';
    $health_status = $_POST['health_status'] ?? '';
    $annual_income = $_POST['annual_income'] ?? 0.00; // Default to 0.00
    $references = $_POST['references'] ?? '';
    $criminal_record = $_POST['criminal_record'] ?? '';
    $adopt_reason = $_POST['adopt_reason'] ?? '';
    $additional_notes = $_POST['additional_notes'] ?? '';
    $status = 'submitted';

    // Handle the code of conduct file upload
    $code_of_conduct = null;
    if (isset($_FILES['code_of_conduct']) && $_FILES['code_of_conduct']['error'] === 0) {
        $upload_dir = 'uploads/';
        $file_name = basename($_FILES['code_of_conduct']['name']);
        $code_of_conduct = $upload_dir . $file_name;
        if (!move_uploaded_file($_FILES['code_of_conduct']['tmp_name'], $code_of_conduct)) {
            echo "<p>Error: Failed to upload the code of conduct file.</p>";
            exit;
        }
    }

    // Insert the data into the database
    $sql = "INSERT INTO home_study_applications 
    (parent_id, full_name, home_address, occupation, marital_status, health_status, annual_income, criminal_record, code_of_conduct, adopt_reason, additional_notes, status, created_at, updated_at)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die('Error preparing the SQL query: ' . $conn->error . ' SQL: ' . $sql);
    }

    $stmt->bind_param(
        "isssssssdsss", 
        $parent_id,          
        $full_name,          
        $home_address,       
        $occupation,         
        $marital_status,     
        $health_status,      
        $annual_income,      
        $criminal_record,    
        $code_of_conduct,    
        $adopt_reason,       
        $additional_notes,   
        $status              
    );
    
    

    // Execute the statement
    if ($stmt->execute()) {
        echo "<div style='text-align: center; margin-top: 50px;'>
                <h2>Thank You!</h2>
                <p>Your Home Study Application has been submitted successfully.</p>
                <a href='index.php' style='text-decoration: none; color: white; background-color: #4caf50; padding: 10px 20px; border-radius: 5px;'>Back to Dashboard</a>
              </div>";
        exit;
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

$conn->close();
?>

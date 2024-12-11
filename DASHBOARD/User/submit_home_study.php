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
    $applicant_email = $_POST['applicant_email'] ?? '';
    $contact_info = $_POST['contact_info'] ?? '';
    $home_address = $_POST['home_address'] ?? '';
    $occupation = $_POST['occupation'] ?? '';
    $marital_status = $_POST['marital_status'] ?? '';
    $health_status = $_POST['health_status'] ?? '';
    $annual_income = $_POST['annual_income'] ?? '';
    $references = $_POST['references'] ?? '';
    $criminal_record = $_POST['criminal_record'] ?? '';
    $adopt_reason = $_POST['adopt_reason'] ?? '';
    $additional_notes = $_POST['additional_notes'] ?? '';

    // Validate required fields
    if (empty($applicant_email) || empty($contact_info)) {
        echo "<p>Error: Applicant email and contact info are required.</p>";
        exit;
    }

    // Handle the code of conduct file upload
    $code_of_conduct = null;
    if (isset($_FILES['code_of_conduct']) && $_FILES['code_of_conduct']['error'] == 0) {
        $code_of_conduct = 'uploads/' . basename($_FILES['code_of_conduct']['name']);
        move_uploaded_file($_FILES['code_of_conduct']['tmp_name'], $code_of_conduct);
    }

    // Insert the data into the database
   // Insert the data into the database
$sql = "INSERT INTO home_study_applications 
(parent_id, full_name, applicant_email, contact_info, home_address, occupation, marital_status, health_status, annual_income, references, criminal_record, code_of_conduct, adopt_reason, additional_notes, status)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
if ($stmt === false) {
die('Error preparing the SQL query: ' . $conn->error);
}

// Bind parameters
$stmt->bind_param(
"isssssssdsssss",  // Updated data types for the parameters
$parent_id,
$full_name,
$applicant_email,
$contact_info,
$home_address,
$occupation,
$marital_status,
$health_status,
$annual_income,
$references,
$criminal_record,
$code_of_conduct,
$adopt_reason,
$additional_notes,
'submitted' // status is a constant value
);


    // Execute the statement
    if ($stmt->execute()) {
        // After successful submission, display a message and stop the form from being shown
        echo "<div style='text-align: center; margin-top: 50px;'>
                <h2>Thank You!</h2>
                <p>Your Home Study Application has been submitted successfully.</p>
                <a href='index.php' style='text-decoration: none; color: white; background-color: #4caf50; padding: 10px 20px; border-radius: 5px;'>Back to Dashboard</a>
              </div>";
        exit; // Stop further execution to prevent form re-display
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>

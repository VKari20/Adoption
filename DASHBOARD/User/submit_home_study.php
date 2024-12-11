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

// Check if the form is already submitted
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if ($row['status'] === 'submitted') {
        // Inform the user that the application has already been submitted
        echo "<div style='text-align: center; margin-top: 50px;'>
                <h2>Thank You!</h2>
                <p>Your Home Study Application has already been submitted.</p>
                <a href='index.php' style='text-decoration: none; color: white; background-color: #4caf50; padding: 10px 20px; border-radius: 5px;'>Back to Dashboard</a>
              </div>";
        exit; // Stop the script from rendering the form again
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $full_name = $_POST['full_name'];
    $home_address = $_POST['home_address'];
    $occupation = $_POST['occupation'];
    $marital_status = $_POST['marital_status'];
    $health_status = $_POST['health_status'];
    $annual_income = $_POST['annual_income'];
    $references = $_POST['references'];
    $criminal_record = $_POST['criminal_record'];
    $adopt_reason = $_POST['adopt_reason'];
    $additional_notes = $_POST['additional_notes'];

    // Handle the code of conduct file upload
    $code_of_conduct = null;
    if (isset($_FILES['code_of_conduct']) && $_FILES['code_of_conduct']['error'] == 0) {
        $code_of_conduct = 'uploads/' . basename($_FILES['code_of_conduct']['name']);
        move_uploaded_file($_FILES['code_of_conduct']['tmp_name'], $code_of_conduct); // Move the file to the uploads directory
    }

    // Insert the data into the database
    $sql = "INSERT INTO home_study_applications 
            (parent_id, full_name, home_address, occupation, marital_status, health_status, annual_income, `references`, criminal_record, code_of_conduct, adopt_reason, additional_notes, status)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'submitted')";

    $stmt = $conn->prepare($sql);

    // Check if the prepare failed
    if ($stmt === false) {
        die('Error preparing the SQL query: ' . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param(
        "isssssssdsss",  // Correct data types for the parameters
        $parent_id,
        $full_name,
        $home_address,
        $occupation,
        $marital_status,
        $health_status,
        $annual_income,
        $references,
        $criminal_record,
        $code_of_conduct,
        $adopt_reason,
        $additional_notes
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

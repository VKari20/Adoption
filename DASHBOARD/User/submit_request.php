<?php
session_start();

require_once 'connection.php'; // Import the database connection

// Check if parent_id is set in the session
if (!isset($_SESSION['parent_id'])) {
    die("Error: No parent ID found. Please log in again.");
}

$parent_id = $_SESSION['parent_id'];

// Check if an adoption request already exists for the current parent
$check_sql = "SELECT adoption_request_number, status FROM adoption_requests WHERE parent_id = ? ORDER BY created_at DESC LIMIT 1";
$check_stmt = $conn->prepare($check_sql);
if (!$check_stmt) {
    die("SQL Error: " . $conn->error);
}
$check_stmt->bind_param("i", $parent_id);
$check_stmt->execute();
$check_stmt->bind_result($existing_request_number, $existing_status);
$check_stmt->fetch();
$check_stmt->close();

// If an adoption request already exists and its status is 'submitted', show the thank-you message and hide the form
if ($existing_request_number && $existing_status === 'submitted') {
    echo "<div style='text-align: center; margin-top: 50px;'>
            <h2>Thank You!</h2>
            <p>Your Adoption Request has already been submitted.</p>
            <p>Your Request Number: <strong>" . htmlspecialchars($existing_request_number) . "</strong></p>
            <p>Status: <strong>" . htmlspecialchars($existing_status) . "</strong></p>
            <a href='index.php' style='text-decoration: none; color: white; background-color: #4caf50; padding: 10px 20px; border-radius: 5px;'>Back to Dashboard</a>
          </div>";
    exit; // Stop further execution to prevent form re-display
}

// Fetch adopter's name and additional data from the prospective_parents table
$sql = "SELECT full_name, home_address, occupation, marital_status, preferences FROM prospective_parents WHERE parent_id = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("SQL Error: " . $conn->error);
}
$stmt->bind_param("i", $parent_id);
$stmt->execute();
$stmt->bind_result($adopter_name, $home_address, $occupation, $marital_status, $preferences);
$stmt->fetch();
$stmt->close();

if (empty($adopter_name)) {
    die("Error: Adopter details could not be retrieved.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate form data
    $adopter_email = $_POST['adopter_email'] ?? '';
    $contact_number = $_POST['contact_number'] ?? '';
    $national_id_number = $_POST['national_id_number'] ?? '';
    $annual_income = $_POST['annual_income'] ?? '';
    $additional_notes = $_POST['additional_notes'] ?? '';

    if (empty($adopter_email) || empty($contact_number) || empty($national_id_number) || empty($annual_income)) {
        die("Error: All required fields must be filled.");
    }

    // Process the uploaded files
    $picture = $code_of_conduct_file_path = '';
    if (isset($_FILES['picture']) && $_FILES['picture']['error'] === UPLOAD_ERR_OK) {
        $picture = 'uploads/' . basename($_FILES['picture']['name']);
        if (!move_uploaded_file($_FILES['picture']['tmp_name'], $picture)) {
            die("Error uploading picture file.");
        }
    }

    if (isset($_FILES['code_of_conduct']) && $_FILES['code_of_conduct']['error'] === UPLOAD_ERR_OK) {
        $code_of_conduct_file_path = 'uploads/' . basename($_FILES['code_of_conduct']['name']);
        if (!move_uploaded_file($_FILES['code_of_conduct']['tmp_name'], $code_of_conduct_file_path)) {
            die("Error uploading code of conduct file.");
        }
    }

    // Generate the custom adoption request number (e.g., REQ-67462A8F000A1)
    $prefix = "REQ-";
    $timestamp = strtoupper(dechex(time()));  // Current timestamp in hexadecimal format
    $random_string = strtoupper(bin2hex(random_bytes(6))); // Random 12-character hex string
    $adoption_request_number = $prefix . $timestamp . $random_string;

    // Insert data into the adoption_requests table, including data from prospective_parents
    $sql = "INSERT INTO adoption_requests (adoption_request_number, parent_id, adopter_name, adopter_email, contact_number, national_id_number, annual_income, additional_notes, picture, code_of_conduct_file_path, home_address, occupation, marital_status, preferences, status)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("SQL Error: " . $conn->error);
    }

    // Define status explicitly
    $status = 'pending';

    // Bind parameters, including the additional fields from prospective_parents
    $stmt->bind_param(
        "sisssssssssssss", 
        $adoption_request_number, 
        $parent_id, 
        $adopter_name, 
        $adopter_email, 
        $contact_number, 
        $national_id_number, 
        $annual_income, 
        $additional_notes, 
        $picture, 
        $code_of_conduct_file_path, 
        $home_address, 
        $occupation, 
        $marital_status, 
        $preferences, 
        $status
    );

    // Execute the query and check success
    if ($stmt->execute()) {
        echo "<div style='text-align: center; margin-top: 50px;'>
                <h2>Thank You!</h2>
                <p>Your Adoption Request has been submitted successfully.</p>
                <a href='index.php' style='text-decoration: none; color: white; background-color: #4caf50; padding: 10px 20px; border-radius: 5px;'>Back to Dashboard</a>
              </div>";
        exit; // Stop further execution to prevent form re-display
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

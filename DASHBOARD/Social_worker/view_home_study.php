<?php
// Start session and connect to the database
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "adoption";

// Database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the application ID from the URL
$applicationId = $_GET['id'] ?? null;

if ($applicationId) {
    // Fetch the application details
    $sql = "SELECT * FROM home_study_applications WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $applicationId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $application = $result->fetch_assoc();
    } else {
        die("Application not found.");
    }
    $stmt->close();
} else {
    die("Invalid application ID.");
}

// Include header
include "nav/nav.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Application</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">Home Study Application Details</h2>
    <table class="table table-bordered">
        <tr>
            <th>Full Name</th>
            <td><?php echo htmlspecialchars($application['full_name']); ?></td>
        </tr>
        <tr>
            <th>Occupation</th>
            <td><?php echo htmlspecialchars($application['occupation']); ?></td>
        </tr>
        <tr>
            <th>Marital Status</th>
            <td><?php echo htmlspecialchars($application['marital_status']); ?></td>
        </tr>
        <tr>
            <th>Reason for Adoption</th>
            <td><?php echo htmlspecialchars($application['adopt_reason']); ?></td>
        </tr>
        <tr>
            <th>Status</th>
            <td><?php echo htmlspecialchars($application['status']); ?></td>
        </tr>
        <tr>
            <th>Created At</th>
            <td><?php echo htmlspecialchars($application['created_at']); ?></td>
        </tr>
    </table>
    <a href="home_study_approvals.php" class="btn btn-secondary">Back</a>
</div>

</body>
</html>

<?php
$conn->close();
?>

<?php
// Start session and connect to the database
session_start();

require_once 'connection.php'; // Import the database connection

// Get application ID from URL
if (isset($_GET['id'])) {
    $application_id = $_GET['id'];
    if (!is_numeric($application_id)) {
        die("Invalid Application ID.");
    }
} else {
    die("Application ID is required.");
}

// Fetch application details
$sql = "SELECT id, parent_id, full_name, home_address, occupation, marital_status, health_status, annual_income, criminal_record, code_of_conduct, adopt_reason, status, additional_notes
        FROM home_study_applications
        WHERE id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Error preparing statement: " . $conn->error);
}

$stmt->bind_param("i", $application_id);
$stmt->execute();
$result = $stmt->get_result();
$application = $result->fetch_assoc();

// If no application is found
if (!$application) {
    die("Application not found.");
}

// Handle form submission for accepting or rejecting
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];
    $notes = $_POST['notes'];

    if ($action == "accept") {
        $new_status = "accepted";
    } elseif ($action == "reject") {
        $new_status = "rejected";
    } else {
        die("Invalid action.");
    }

    // Update the application status
    $update_sql = "UPDATE home_study_applications 
                   SET status = ?, additional_notes = ? 
                   WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);

    if (!$update_stmt) {
        die("Error preparing update statement: " . $conn->error);
    }

    $update_stmt->bind_param("ssi", $new_status, $notes, $application_id);
    
    if ($update_stmt->execute()) {
        echo "<script>alert('Application has been $new_status successfully.');</script>";
        echo "<script>window.location.href = 'new_applications.php';</script>";
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Include header
include "nav/header.php";
?>

<!-- Main Content -->
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">View Application</h1>
    </div>

    <div class="container mt-5">
      
        <table class="table table-bordered">
            <tr>
                <th>Application ID</th>
                <td><?php echo htmlspecialchars($application['id']); ?></td>
            </tr>
            <tr>
                <th>Parent ID</th>
                <td><?php echo htmlspecialchars($application['parent_id']); ?></td>
            </tr>
            <tr>
                <th>Full Name</th>
                <td><?php echo htmlspecialchars($application['full_name']); ?></td>
            </tr>
            <tr>
                <th>Home Address</th>
                <td><?php echo htmlspecialchars($application['home_address']); ?></td>
            </tr>
            <tr>
                <th>Status</th>
                <td><?php echo htmlspecialchars($application['status']); ?></td>
            </tr>
            <tr>
                <th>Additional Notes</th>
                <td><?php echo htmlspecialchars($application['additional_notes']); ?></td>
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
                <th>Health Status</th>
                <td><?php echo htmlspecialchars($application['health_status']); ?></td>
            </tr>
            <tr>
                <th>Annual Income</th>
                <td><?php echo htmlspecialchars($application['annual_income']); ?></td>
            </tr>
            <!-- <tr>
                <th>References</th>
                <td><?php echo htmlspecialchars($application['references']); ?></td>
            </tr> -->
            <tr>
                <th>Climinal Record</th>
                <td><?php echo htmlspecialchars($application['criminal_record']); ?></td>
            </tr>
            <tr>
                <th>Code of Conduct</th>
                <td><?php echo htmlspecialchars($application['code_of_conduct']); ?></td>
            </tr>
        </table>

        <!-- Action Form -->
        <form method="post">
            <div class="form-group">
                <label for="notes">Additional Notes</label>
                <textarea name="notes" id="notes" class="form-control" rows="4" required></textarea>
            </div>
            <button type="submit" name="action" value="accept" class="btn btn-success">Accept</button>
            <button type="submit" name="action" value="reject" class="btn btn-danger">Reject</button>
        </form>

        <a href="new_adoption_application.php" class="btn btn-secondary mt-3">Back to Applications</a>

    </div>
</main>

<footer>
        <p>&copy; 2024 Kids Adoption. All rights reserved.</p>
</footer>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>

<?php
// Start session and connect to the database
session_start();

require_once 'connection.php'; // Import the database connection

// Get application ID from URL
if (isset($_GET['id'])) {
    $application_id = $_GET['id'];
} else {
    die("Application ID is required.");
}

// Fetch application details
$sql = "SELECT application_id, parent_id, application_date, application_status, review_notes, final_decision_date 
        FROM adoption_applications 
        WHERE application_id = ?";
$stmt = $conn->prepare($sql);
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
    $update_sql = "UPDATE adoption_applications 
                   SET application_status = ?, review_notes = ?, final_decision_date = NOW() 
                   WHERE application_id = ?";
    $update_stmt = $conn->prepare($update_sql);
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
        <h2 class="mb-4">Application Details</h2>
        <table class="table table-bordered">
            <tr>
                <th>Application ID</th>
                <td><?php echo htmlspecialchars($application['application_id']); ?></td>
            </tr>
            <tr>
                <th>Parent ID</th>
                <td><?php echo htmlspecialchars($application['parent_id']); ?></td>
            </tr>
            <tr>
                <th>Application Date</th>
                <td><?php echo htmlspecialchars($application['application_date']); ?></td>
            </tr>
            <tr>
                <th>Status</th>
                <td><?php echo htmlspecialchars($application['application_status']); ?></td>
            </tr>
            <tr>
                <th>Review Notes</th>
                <td><?php echo htmlspecialchars($application['review_notes']); ?></td>
            </tr>
            <tr>
                <th>Final Decision Date</th>
                <td><?php echo htmlspecialchars($application['final_decision_date']); ?></td>
            </tr>
        </table>

        <!-- Action Form -->
        <form method="post">
            <div class="form-group">
                <label for="notes">Review Notes</label>
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

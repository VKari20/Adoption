<?php
session_start();

require_once 'connection.php'; // Import the database connection

// Check if 'id' is set in the query string
if (isset($_GET['id'])) {
    $request_id = $_GET['id'];

    // Fetch the request details
    $sql = "SELECT id, adoption_request_number, adopter_name, status, adopter_email, contact_number, national_id_number, annual_income, preferences, home_address, occupation, marital_status, additional_notes, picture, code_of_conduct_file_path 
            FROM adoption_requests WHERE id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $request_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        die("Request not found");
    }
    $stmt->close();
} else {
    die("Invalid request");
}

// If the form is submitted to take action
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];  // Accept or Reject

    // Validate the action
    if ($action == "Accepted" || $action == "Rejected") {
        // Update the request status based on the action taken
        $update_sql = "UPDATE adoption_requests SET status = ? WHERE id = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("si", $action, $request_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            // Action taken successfully
            $message = "Request has been $action successfully.";
        } else {
            // Error occurred while updating the status
            $message = "Error updating the status.";
        }

        $stmt->close();

        // Redirect to the appropriate list page with the success message
        if ($action == "Accepted") {
            header("Location: accepted_requests.php?message=" . urlencode($message));
        } else {
            header("Location: rejected_requests.php?message=" . urlencode($message));
        }
        exit();
    } else {
        // Invalid action selected
        $message = "Invalid action.";
    }
}

include "nav/header.php";
?>

<!-- Main Content -->
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Take Action on Adoption Request - <?php echo $row['adopter_name']; ?></h1>
    </div>

    <div class="container mt-5">
        <h2>Adoption Request Details</h2>

        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th>Adoption Request Number</th>
                    <td><?php echo $row['adoption_request_number']; ?></td>
                </tr>
                <tr>
                    <th>Adopter Name</th>
                    <td><?php echo $row['adopter_name']; ?></td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td><?php echo $row['status']; ?></td>
                </tr>
                <tr>
                    <th>Adopter Email</th>
                    <td><?php echo $row['adopter_email']; ?></td>
                </tr>
                <tr>
                    <th>Contact Number</th>
                    <td><?php echo $row['contact_number']; ?></td>
                </tr>
                <tr>
                    <th>National ID</th>
                    <td><?php echo $row['national_id_number']; ?></td>
                </tr>
                <tr>
                    <th>Annual Income</th>
                    <td><?php echo $row['annual_income']; ?></td>
                </tr>
                <tr>
                    <th>Preferences</th>
                    <td><?php echo $row['preferences']; ?></td>
                </tr>
                <tr>
                    <th>Home Address</th>
                    <td><?php echo $row['home_address']; ?></td>
                </tr>
                <tr>
                    <th>Occupation</th>
                    <td><?php echo $row['occupation']; ?></td>
                </tr>
                <tr>
                    <th>Marital Status</th>
                    <td><?php echo $row['marital_status']; ?></td>
                </tr>
                <tr>
                    <th>Additional Notes</th>
                    <td><?php echo $row['additional_notes']; ?></td>
                </tr>
                <tr>
                    <th>Profile Picture</th>
                    <td><img src="uploads/<?php echo $row['picture']; ?>" alt="Profile Picture" style="max-width: 150px;"></td>
                </tr>
                <tr>
                    <th>Code of Conduct</th>
                    <td><a href="uploads/<?php echo $row['code_of_conduct_file_path']; ?>" target="_blank">Download Code of Conduct</a></td>
                </tr>
            </tbody>
        </table>

        <!-- Form to take action (Accept/Reject) -->
        <form method="POST" action="take_action.php?id=<?php echo $row['id']; ?>">
            <div class="form-group">
                <label for="action">Action:</label>
                <select name="action" id="action" class="form-control" required>
                    <option value="Accepted">Accept</option>
                    <option value="Rejected">Reject</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Submit Action</button>
        </form>

        <?php
        if (isset($message)) {
            echo "<div class='alert alert-info mt-3'>$message</div>";
        }
        ?>
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

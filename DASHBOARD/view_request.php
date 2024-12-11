<?php
// Start the session and enable error reporting for debugging
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Include the database connection
require_once 'connection.php';

// Check if the parent_id is passed in the URL
if (isset($_GET['id'])) {
    $parent_id = $_GET['id'];

    // Query to fetch the adoption request details based on parent_id
    $sql = "SELECT * FROM adoption_requests WHERE parent_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $parent_id);  // Assuming parent_id is an integer
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc(); // Fetch the details
    } else {
        die("Adoption request not found.");
    }
} else {
    die("Invalid request ID.");
}

// Include the header
include "nav/header.php";
?>

<!-- Main Content -->
<main role="main" class="container mt-5">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">View Adoption Request - <?php echo $row['adopter_name']; ?></h1>
    </div>

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
                <th>Adopter Email</th>
                <td><?php echo $row['adopter_email']; ?></td>
            </tr>
            <tr>
                <th>Contact Number</th>
                <td><?php echo $row['contact_number']; ?></td>
            </tr>
            <tr>
                <th>Status</th>
                <td><?php echo $row['status']; ?></td>
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
                <th>Preferences</th>
                <td><?php echo $row['preferences']; ?></td>
            </tr>
            <tr>
                <th>National ID Number</th>
                <td><?php echo $row['national_id_number']; ?></td>
            </tr>
            <tr>
                <th>Annual Income</th>
                <td><?php echo $row['annual_income']; ?></td>
            </tr>
            <tr>
                <th>Additional Notes</th>
                <td><?php echo $row['additional_notes']; ?></td>
            </tr>
            <tr>
                <th>Profile Picture</th>
                <td>
                    <?php
                    if ($row['picture']) {
                        echo "<img src='uploads/" . $row['picture'] . "' alt='Profile Picture' class='img-fluid' width='150'>";
                    } else {
                        echo "No picture available.";
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <th>Code of Conduct</th>
                <td>
                    <a href="uploads/<?php echo $row['code_of_conduct_file_path']; ?>" target="_blank">View Code of Conduct</a>
                </td>
            </tr>
            <tr>
                <th>Created At</th>
                <td><?php echo $row['created_at']; ?></td>
            </tr>
        </tbody>
    </table>

    <!-- Take Action Section -->
    <div class="form-group">
        <h3>Take Action</h3>
        <a href="accept_request.php?id=<?php echo htmlspecialchars($row['parent_id']); ?>" 
           class="btn btn-success btn-lg" 
           onclick="return confirm('Are you sure you want to accept this request?')">Accept</a>
        <a href="reject_request.php?id=<?php echo htmlspecialchars($row['parent_id']); ?>" 
           class="btn btn-danger btn-lg" 
           onclick="return confirm('Are you sure you want to reject this request?')">Reject</a>
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
// Close the database connection at the end of the script
$conn->close();
?>

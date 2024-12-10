<?php 
// Start session and connect to the database
session_start();

require_once 'connection.php'; // Include your database connection file

// Check if 'parent_id' is set in the query string
if (isset($_GET['id'])) {
    $parent_id = $_GET['id']; // Assuming you're passing parent_id in the URL

    // Modify the query to fetch data using the parent_id
    $sql = "SELECT parent_id, adoption_request_number, adopter_name, adopter_email, contact_number, status, 
            picture, code_of_conduct_file_path, national_id_number, annual_income, preferences, 
            home_address, occupation, marital_status, additional_notes, created_at
            FROM adoption_requests WHERE parent_id = ?";  // Use parent_id here

    // Prepare and execute the query safely
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error in preparing statement: " . $conn->error);
    }
    
    $stmt->bind_param("i", $parent_id);  // 'i' for integer because parent_id is assumed to be an integer
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the record exists
    if ($result->num_rows > 0) {
        // Fetch the data of the request
        $row = $result->fetch_assoc();
    } else {
        die("Request not found");
    }

    $stmt->close();
} else {
    die("Invalid request");
}

// Include header
include "nav/header.php";
?>

<!-- Main Content -->
<main role="main" class="container mt-5">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">View Adoption Request - <?php echo $row['adopter_name']; ?></h1>
    </div>

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
    <?php if (isset($row['parent_id'])): ?>
        <a href="accept_request.php?id=<?php echo htmlspecialchars($row['parent_id']); ?>" 
           class="btn btn-success btn-lg" 
           onclick="return confirm('Are you sure you want to accept this request?')">Accept</a>
        <a href="reject_request.php?id=<?php echo htmlspecialchars($row['parent_id']); ?>" 
           class="btn btn-danger btn-lg" 
           onclick="return confirm('Are you sure you want to reject this request?')">Reject</a>
    <?php else: ?>
        <p>Error: Parent ID is not set.</p>
    <?php endif; ?>
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

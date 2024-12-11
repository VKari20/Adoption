<?php
// Start session and include the database connection
session_start();
require_once 'connection.php';

// Check if the 'adoption_request_number' parameter is passed in the URL
if (isset($_GET['adoption_request_number']) && !empty($_GET['adoption_request_number'])) {
    $adoption_request_number = $_GET['adoption_request_number']; // Retrieve the adoption request number from the URL

    // Debugging output to confirm the adoption_request_number
    echo "Adoption Request Number: " . $adoption_request_number . "<br>";  // This should print the value passed in the URL

    // Your existing query to update status goes here
    $sql = "UPDATE adoption_requests SET status = 'accepted' WHERE adoption_request_number = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        die("Error preparing the SQL query: " . $conn->error);
    }

    $stmt->bind_param("s", $adoption_request_number); // 's' for string as adoption_request_number is a varchar

    // Execute the query
    if ($stmt->execute()) {
        // Redirect to the same page to show updated status
        header("Location: accept_request.php");
        exit();  // Ensure the script stops after the redirect
    } else {
        echo"Error updating status: {$stmt->error}";
    }
} 
// else {
//     echo"Invalid or missing adoption request number. Please check the URL.";
// }


// Fetch accepted adoption requests
$sql = "SELECT adoption_request_number, adopter_name, adopter_email, contact_number, status, parent_id FROM adoption_requests WHERE status = 'accepted'";
$result = $conn->query($sql);

if ($result === false) {
    echo"Error fetching accepted requests: " . $conn->error;
}
$conn->close();


include "nav/header.php"; // Include header or navigation bar

?>

<!-- Main Content -->
<main role="main" class="container mt-5">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Accepted Adoption Requests</h1>
    </div>

    <div class="container mt-5">
        <h2 class="mb-4">Accepted Requests</h2>

        <!-- Check if there are any accepted requests -->
        <?php if ($result->num_rows > 0): ?>
            <table id="adoptionRequests" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Adoption Request Number</th>
                        <th>Adopter Name</th>
                        <th>Adopter Email</th>
                        <th>Contact Number</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $s_no = 1; // Variable to display serial numbers
                    while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $s_no++; ?></td>
                            <td><?= htmlspecialchars($row["adoption_request_number"]); ?></td>
                            <td><?= htmlspecialchars($row["adopter_name"]); ?></td>
                            <td><?= htmlspecialchars($row["adopter_email"]); ?></td>
                            <td><?= htmlspecialchars($row["contact_number"]); ?></td>
                            <td><span class="badge bg-success"><?= htmlspecialchars($row["status"]); ?></span></td>
                            <td>
                                <!-- View request button -->
                                <a href="view_request.php?id=<?= htmlspecialchars($row["parent_id"]); ?>" class="btn btn-info"><i class="fa fa-eye"></i> View</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="alert alert-info text-center">No accepted adoption requests found.</p>
        <?php endif; ?>
    </div>
</main>

<!-- Footer -->
<footer class="footer mt-5">
    <div class="container">
        <span class="text-muted">© 2024 OrphanConnect by Vennesa</span>
    </div>
</footer>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<!-- DataTable initialization -->
<script>
    $(document).ready(function() {
        $('#adoptionRequests').DataTable();
    });
</script>

</body>
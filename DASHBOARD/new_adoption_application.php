<?php
// Start session and connect to the database
session_start();

require_once 'connection.php'; // Import the database connection

// Fetch new adoption applications from the database
$sql = "SELECT application_id, parent_id, application_date, application_status, review_notes
        FROM adoption_applications
        WHERE application_status = 'under review' AND final_decision_date IS NULL
        ORDER BY application_date DESC";
$result = $conn->query($sql);

// Include header (ensure the path is correct)
include "nav/header.php";
?>

<!-- Main Content -->
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">New Adoption Applications</h1>
        <a href="download_new_applications.php" class="btn btn-success">Download Report</a>
    </div>

    <div class="container mt-5">
        <h2 class="mb-4">New Applications</h2>
        <table id="newApplications" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Application ID</th>
                    <th>Parent ID</th>
                    <th>Application Date</th>
                    <th>Status</th>
                    <th>Review Notes</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Check if there are records in the result set
                if ($result->num_rows > 0) {
                    $sno = 1; // Serial number
                    // Fetch each row and display it in the table
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$sno}</td>";  // Serial number
                        echo "<td>{$row['application_id']}</td>";  // Application ID
                        echo "<td>{$row['parent_id']}</td>";  // Parent ID
                        echo "<td>{$row['application_date']}</td>";  // Application Date
                        echo "<td>{$row['application_status']}</td>";  // Application Status
                        echo "<td>{$row['review_notes']}</td>";  // Review Notes
                        echo "<td><a href='view_application.php?id={$row['application_id']}' class='btn btn-primary btn-sm'>View</a></td>";
                        echo "</tr>";
                        $sno++;
                    }
                } else {
                    echo "<tr><td colspan='7'>No new adoption applications found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</main>

<!-- Initialize DataTable -->
<script>
    $(document).ready(function() {
        $('#newApplications').DataTable();
    });
</script>

<footer>
        <p>&copy; 2024 Kids Adoption. All rights reserved.</p>
    </footer>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>

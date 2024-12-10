<?php
session_start();

require_once 'connection.php'; // Import the database connection

// Fetch rejected adoption applications from the database
$sql = "SELECT application_id, child_id, parent_id, application_date, application_status, review_notes, final_decision_date 
        FROM adoption_applications 
        WHERE application_status = 'rejected'";  // Only fetch rejected applications
$result = $conn->query($sql);


include "nav/header.php";
?>

<!-- Main Content -->
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Rejected Adoption Applications</h1>
       <!-- <a href="download_rejected_applications.php" class="btn btn-danger">Download Report</a>-->
    </div>

    <div class="container mt-5">
        <h2 class="mb-4">Rejected Adoption Applications</h2>
        <table id="rejectedApplications" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Application ID</th>
                    <th>Child ID</th>
                    <th>Parent ID</th>
                    <th>Application Date</th>
                    <th>Status</th>
                    <th>Review Notes</th>
                    <th>Final Decision Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Check if there are records in the result set
                if ($result->num_rows > 0) {
                    // Fetch each row and display it in the table
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$row['application_id']}</td>";
                        echo "<td>{$row['application_id']}</td>";  // Display Application ID
                        echo "<td>{$row['child_id']}</td>";  // Display Child ID
                        echo "<td>{$row['parent_id']}</td>";  // Display Parent ID
                        echo "<td>{$row['application_date']}</td>";  // Display Application Date
                        echo "<td>{$row['application_status']}</td>";  // Display Application Status
                        echo "<td>{$row['review_notes']}</td>";  // Display Review Notes
                        echo "<td>{$row['final_decision_date']}</td>";  // Display Final Decision Date
                        echo "<td><a href='view_rejected_application.php?id={$row['application_id']}' class='btn btn-primary btn-sm'>View</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>No rejected adoption applications found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</main>

<!-- Initialize DataTable -->
<script>
    $(document).ready(function() {
        $('#rejectedApplications').DataTable();
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

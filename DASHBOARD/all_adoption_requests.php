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

// Fetch data from the database
$sql = "SELECT parent_id AS id, adoption_request_number, adopter_name, adopter_email, contact_number, status FROM adoption_requests";
$result = $conn->query($sql);

// Check if the query was successful
if (!$result) {
    // Output the error if the query failed
    die("Error executing query: " . $conn->error);
}

// Include header
include "nav/header.php";
?>

<!-- Main Content -->
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">All Adoption Requests</h1>
        <a href="downlaod_requests.php" class="btn btn-success">Download Report</a>
    </div>

    <div class="container mt-5">
        <h2 class="mb-4">Adoption Requests</h2>
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
                // Check if there are records in the result set
                if ($result->num_rows > 0) {
                    // Fetch each row and display it in the table
                    $serialNo = 1;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$serialNo}</td>"; // Display the serial number
                        echo "<td>{$row['adoption_request_number']}</td>";
                        echo "<td>{$row['adopter_name']}</td>";
                        echo "<td>{$row['adopter_email']}</td>";
                        echo "<td>{$row['contact_number']}</td>";
                        echo "<td>{$row['status']}</td>";
                        echo "<td><a href='view_request.php?id={$row['id']}' class='btn btn-primary btn-sm'>View</a></td>";
                        echo "</tr>";
                        $serialNo++; // Increment the serial number
                    }
                } else {
                    echo "<tr><td colspan='7'>No records found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</main>

<!-- Initialize DataTable -->
<script>
    $(document).ready(function() {
        $('#adoptionRequests').DataTable();
    });
</script>

<!-- Footer -->
<footer class="footer">
    <div class="container">
        <span class="text-muted">© 2024 OrphanConnect by Vennesa</span>
    </div>
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

<?php
require_once 'connection.php'; // Import the database connection

// Check if the database connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch only rejected adoption requests
$sql = "SELECT parent_id, adoption_request_number, adopter_name, adopter_email, contact_number, status FROM adoption_requests WHERE status = 'rejected'";

// Execute the query and check if it was successful
$result = $conn->query($sql);

if (!$result) {
    // Query failed, show an error message
    die("Error executing query: " . $conn->error);
}

$conn->close();

include "nav/header.php";
?>

<!-- Main Content -->
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Rejected Adoption Requests</h1>
    </div>
    <body>
    <div class="container mt-5">
        
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
                if ($result->num_rows > 0) {
                    $s_no = 1; // To display serial number
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $s_no++ . "</td>
                                <td>" . htmlspecialchars($row["adoption_request_number"]) . "</td>
                                <td>" . htmlspecialchars($row["adopter_name"]) . "</td>
                                <td>" . htmlspecialchars($row["adopter_email"]) . "</td>
                                <td>" . htmlspecialchars($row["contact_number"]) . "</td>
                                <td>" . htmlspecialchars($row["status"]) . "</td>
                                <td>
                                    <a href='view_request.php?id=" . htmlspecialchars($row["parent_id"]) . "' class='btn btn-info'><i class='fa fa-eye'></i> View</a>
                                    <a href='undo_rejection.php?id=" . htmlspecialchars($row["parent_id"]) . "' class='btn btn-success'><i class='fa fa-refresh'></i> Undo Rejection</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7' class='text-center'>No rejected adoption requests found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Initialize DataTable -->
    <script>
        $(document).ready(function() {
            $('#adoptionRequests').DataTable();
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
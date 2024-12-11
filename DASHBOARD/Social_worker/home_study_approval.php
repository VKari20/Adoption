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

// Fetch home study requests
$sql = "SELECT * FROM home_study_requests";
$result = $conn->query($sql);

// Include header
include "nav/header.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Study Approvals</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>

<!-- Main Content -->
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Home Study Approvals</h1>
    </div>

    <div class="container mt-5">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Adopter Name</th>
                        <th>Adopter Email</th>
                        <th>Request Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Check if there are records in the result set
                    if ($result->num_rows > 0) {
                        // Fetch each row and display it in the table
                        $count = 1;
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $count . "</td>";
                            echo "<td>" . htmlspecialchars($row['adopter_name']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['adopter_email']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['request_date']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                            echo "<td>
                                    <a href='approve_home_study.php?id=" . $row['request_id'] . "&action=approve' class='btn btn-success btn-sm'>Approve</a>
                                    <a href='approve_home_study.php?id=" . $row['request_id'] . "&action=reject' class='btn btn-danger btn-sm'>Reject</a>
                                  </td>";
                            echo "</tr>";
                            $count++;
                        }
                    } else {
                        echo "<tr><td colspan='6'>No requests found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<!-- Footer -->
<footer>
    <p>&copy; 2024 Adoption System. All rights reserved.</p>
</footer>

<!-- jQuery, Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>

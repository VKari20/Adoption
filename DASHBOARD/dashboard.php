<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit;
}


// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
header("Location: login.php?message=Please log in to access the dashboard&type=error");
exit();
}


// Display different content based on user role
$role = $_SESSION['role'];

require_once 'connection.php'; // Import the database connection


$count_sql = "SELECT COUNT(*) as total_children FROM children";
$count_result = $conn->query($count_sql);
$total_children = 0;

if ($count_result->num_rows > 0) {
    $row = $count_result->fetch_assoc();
    $total_children = $row['total_children'];
}

// Query to get the total count of users
$count_users_sql = "SELECT COUNT(*) as total_users FROM users";
$count_users_result = $conn->query($count_users_sql);
$total_users = 0;

if ($count_users_result->num_rows > 0) {
    $row = $count_users_result->fetch_assoc();
    $total_users = $row['total_users'];
}

// Count pending adoption applications
$count_pending_sql = "SELECT COUNT(*) as pending_applications FROM adoption_applications WHERE application_status = 'pending'";
$count_pending_result = $conn->query($count_pending_sql);
$pending_applications = $count_pending_result->fetch_assoc()['pending_applications'] ?? 0;

// Count under review adoption applications
$count_under_review_sql = "SELECT COUNT(*) as under_review_applications FROM adoption_applications WHERE application_status = 'under review'";
$count_under_review_result = $conn->query($count_under_review_sql);
$under_review_applications = $count_under_review_result->fetch_assoc()['under_review_applications'] ?? 0;

// Count approved adoption applications
$count_approved_sql = "SELECT COUNT(*) as approved_applications FROM adoption_applications WHERE application_status = 'approved'";
$count_approved_result = $conn->query($count_approved_sql);
$approved_applications = $count_approved_result->fetch_assoc()['approved_applications'] ?? 0;

// Count rejected adoption applications
$count_rejected_sql = "SELECT COUNT(*) as rejected_applications FROM adoption_applications WHERE application_status = 'rejected'";
$count_rejected_result = $conn->query($count_rejected_sql);
$rejected_applications = $count_rejected_result->fetch_assoc()['rejected_applications'] ?? 0;

$conn->close();


include "nav/header.php"

?>

<!-- Main Content -->
<main role="main" class="pt-3">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2">Dashboard</h1>
        </div>

    <!-- Stats Cards -->
    <div class="row">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="card-body">
                            <h5 class="card-title" style="color:white">Total Children</h5>
                            <h3 style="color:white"><?php echo $total_children; ?></h3>
                        </div>
                        <i class="fa fa-child fa-3x"></i>
                    </div>
                    <a href="manage_kids.php" class="btn btn-light mt-3">View Details</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                       <!-- Display Total Users -->
    <div class="card bg-success mb-4">
        <div class="card-body">
            <h5 class="card-title" style="color:white">Total Users</h5>
            <h3 style="color:white"><?php echo $total_users; ?></h3>
        </div>
    </div>
                        <i class="fa fa-users fa-3x"></i>
                    </div>
                    <a href="manage_parents.php" class="btn btn-light mt-3">View Details</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title" style="color:white">All Adoption Applications</h5>
                            <h3 style="color:white">5</h3>
                        </div>
                        <i class="fa fa-money fa-3x"></i>
                    </div>
                    <a href="#" class="btn btn-light mt-3">View Details</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="card text-white bg-info mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title" style="color:white">New Adoption Request</h5>
                            <h3style="color:white">0</h3>
                        </div>
                        <i class="fa fa-envelope fa-3x"></i>
                    </div>
                    <a href="new_adoption_request.php" class="btn btn-light mt-3">View Details</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title" style="color:white">Accepted Adoption Request</h5>
                            <h3 style="color:white">2</h3>
                        </div>
                        <i class="fa fa-check fa-3x"></i>
                    </div>
                    <a href="accepted_requests.php" class="btn btn-light mt-3">View Details</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-danger mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title" style="color:white">Rejected Adoption Request</h5>
                            <h3 style="color:white">1</h3>
                        </div>
                        <i class="fa fa-times fa-3x"></i>
                    </div>
                    <a href="rejected_requests.php" class="btn btn-light mt-3">View Details</a>
                </div>
            </div>
        </div>
    </div>
</main>
</div>
</div>

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
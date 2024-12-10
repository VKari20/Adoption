<?php
//session_start();

// Check if user is logged in
// if (!isset($_SESSION['user_id'])) {
//     header("Location: login.php?message=Please log in to access the dashboard&type=error");
//     exit();
// }

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "adoption";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query for total children count
//$count_children_sql = "SELECT COUNT(*) as total_children FROM children";
//$count_children_result = $conn->query($count_children_sql);
//$total_children = $count_children_result->fetch_assoc()['total_children'] ?? 0;

// Query for total parents count
//$count_parents_sql = "SELECT COUNT(*) as total_parents FROM parents";
//$count_parents_result = $conn->query($count_parents_sql);
//$total_parents = $count_parents_result->fetch_assoc()['total_parents'] ?? 0;

// Query for total appointments
//$count_appointments_sql = "SELECT COUNT(*) as total_appointments FROM appointments";
//$count_appointments_result = $conn->query($count_appointments_sql);
//$total_appointments = $count_appointments_result->fetch_assoc()['total_appointments'] ?? 0;

// Query for pending appointments
//$count_pending_appointments_sql = "SELECT COUNT(*) as pending_appointments FROM appointments WHERE status = 'pending'";
//$count_pending_appointments_result = $conn->query($count_pending_appointments_sql);
//$pending_appointments = $count_pending_appointments_result->fetch_assoc()['pending_appointments'] ?? 0;

//include "DASHBOARD/nav/header.php";
?>

<!-- Main Content -->
<main role="main" class="pt-3">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <h1 class="h2">Doctor's Dashboard</h1>
    </div>

    <!-- Stats Cards -->
    <div class="row">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
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
            <div class="card text-white bg-info mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title" style="color:white">Total Appointments</h5>
                            <h3 style="color:white"><?php echo $total_appointments; ?></h3>
                        </div>
                        <i class="fa fa-calendar fa-3x"></i>
                    </div>
                    <a href="manage_appointments.php" class="btn btn-light mt-3">View Details</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title" style="color:white">Pending Appointments</h5>
                            <h3 style="color:white"><?php echo $pending_appointments; ?></h3>
                        </div>
                        <i class="fa fa-clock-o fa-3x"></i>
                    </div>
                    <a href="pending_appointments.php" class="btn btn-light mt-3">View Details</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title" style="color:white">Total Parents</h5>
                            <h3 style="color:white"><?php echo $total_parents; ?></h3>
                        </div>
                        <i class="fa fa-users fa-3x"></i>
                    </div>
                    <a href="manage_parents.php" class="btn btn-light mt-3">View Details</a>
                </div>
            </div>
        </div>
    </div>
</main>

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
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</body>

</html>

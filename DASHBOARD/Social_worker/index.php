<?php
// Start the session to access session variables
session_start();

require_once 'connection.php'; // Include your database connection

// Check if the user is logged in and if they have the correct role (social worker)
if (!isset($_SESSION['social_worker_logged_in']) || $_SESSION['role'] != 7) {
    // If the user is not logged in or doesn't have the correct role, redirect to the login page
    header("Location: login.php");
    exit;
}

// Assuming user is logged in, get the user ID from the session
$user_id = $_SESSION['user_id'];

try {
    // Fetching children data
    $children_stmt = $pdo->query("SELECT * FROM children");
    $children = $children_stmt->fetchAll();

} catch (Exception $e) {
    echo "Error fetching data: " . $e->getMessage();
    exit;
}

include "nav/nav.php"; // Include navigation
?>

<!-- dashboard.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <style>
        /* General Layout */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f9;
    color: #333;
}

/* Container for content */
.container-fluid {
    margin-top: 30px;
}

/* Header Section */
h1 {
    font-size: 2.5rem;
    color: #333;
}

h3 {
    font-size: 1.8rem;
    margin-top: 20px;
    color: #333;
}

p {
    font-size: 1.2rem;
    color: #666;
}

/* Cards for Statistics */
.card {
    margin-bottom: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: box-shadow 0.3s ease;
}

.card:hover {
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

.card-body {
    text-align: center;
}

.card-title {
    font-size: 1.4rem;
    font-weight: bold;
    color: #444;
}

.card-text {
    font-size: 1.2rem;
    color: #007bff;
}

/* Quick Links Section */
ul {
    list-style-type: none;
    padding: 0;
}

ul li {
    font-size: 1.2rem;
    margin-bottom: 10px;
}

ul li a {
    color: #007bff;
    text-decoration: none;
    font-weight: bold;
}

ul li a:hover {
    text-decoration: underline;
}

/* Responsive Design for Cards */
@media (max-width: 767px) {
    .card {
        margin-bottom: 15px;
    }

    .col-md-4 {
        margin-bottom: 20px;
    }

    h1 {
        font-size: 2rem;
    }

    h3 {
        font-size: 1.5rem;
    }
}

    </style>
</head>
<body>
    <div class="container-fluid">
        <h1>Dashboard Overview</h1>
        <p>Welcome to the dashboard! Below is a quick overview of key statistics:</p>

        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Children Under Care</h5>
                        <p class="card-text">Number of children: <strong>15</strong></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Open Cases</h5>
                        <p class="card-text">Number of open cases: <strong>5</strong></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Pending Adoptions</h5>
                        <p class="card-text">Number of pending adoptions: <strong>3</strong></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dashboard Task and Management Links -->
        <div class="mt-4">
            <h3>Quick Links</h3>
            <ul>
                <li><a href="manage_kids.php">Manage Children</a></li>
                <li><a href="task_management.php">Task Management</a></li>
                <li><a href="reports.php">Reports and Documentation</a></li>
                <li><a href="home_study_approvals.php">Home Study Approvals</a></li>
            </ul>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    
    <?php include "nav/footer.php"; ?>
</body>
</html>




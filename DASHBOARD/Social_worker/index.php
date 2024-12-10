<?php
// Start the session to access session variables
//session_start();

require_once 'connection.php'; // Include your database connection

// Check if the user is logged in and if they have the correct role (social worker)
if (!isset($_SESSION['social_worker_logged_in']) || $_SESSION['role'] != 'social worker') {
     //If the user is not logged in or doesn't have the correct role, redirect to the login page
    header("Location: login.php");
   exit;
}

// Assuming user is logged in, get the user ID from session
$user_id = $_SESSION['user_id'];

// Fetching children data
$children_stmt = $pdo->query("SELECT * FROM children");
$children = $children_stmt->fetchAll();

include "nav/nav.php"; // Include navigation
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Social Worker Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="dashboard-container">
        <div class="section">
            <h2>Children List</h2>
            <table>
                <tr>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Status</th>
                    <th>Admission Date</th>
                </tr>
                <?php
                // Loop through children and display data
                foreach ($children as $child) {
                    echo "<tr>
                            <td>{$child['name']}</td>
                            <td>{$child['age']}</td>
                            <td>{$child['status']}</td>
                            <td>{$child['admission_date']}</td>
                          </tr>";
                }
                ?>
            </table>
        </div>

        <div class="section">
            <h2>Your Tasks</h2>
            <table>
                <tr>
                    <th>Task</th>
                    <th>Due Date</th>
                </tr>
                <!-- You can dynamically fetch tasks from the database here -->
                <!-- Example of displaying task -->
                <!-- <tr><td>Task 1</td><td>2024-12-15</td></tr> -->
            </table>
        </div>

        <div class="section">
            <h2>Recent Reports</h2>
            <table>
                <tr>
                    <th>Child Name</th>
                    <th>Report Date</th>
                    <th>Description</th>
                </tr>
                <!-- Example of displaying reports -->
                <!-- <tr><td>Child 1</td><td>2024-12-10</td><td>Report details...</td></tr> -->
            </table>
        </div>
    </div>

    <?php include "nav/footer.php"; ?>
</body>
</html>

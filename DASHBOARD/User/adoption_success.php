<?php
require_once 'connection.php';
session_start();

// Assuming the logged-in user's parent ID is stored in the session
if (!isset($_SESSION['parent_id'])) {
    header("Location: login.php"); // Redirect to login if not authenticated
    exit;
}

$parent_id = $_SESSION['parent_id'];

// Fetch adoption details for the logged-in parent
$query = "
    SELECT 
        c.child_id,
        c.full_name AS child_name,
        c.date_of_birth,
        c.disability,
        m.date_assigned
    FROM 
        matches m
    INNER JOIN 
        children c ON m.child_id = c.child_id
    WHERE 
        m.parent_id = ? 
    ORDER BY 
        m.date_assigned DESC 
    LIMIT 1"; // Fetch the most recent adoption

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $parent_id);
$stmt->execute();
$result = $stmt->get_result();
$adoption = $result->fetch_assoc();

include "nav/nav.php"; // Include navigation header
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adoption Success</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: #f8f9fa;
            min-height: 100vh;
        }
        .content {
            margin-top: 50px;
            padding: 20px;
            background: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            max-width: 600px;
            text-align: center;
        }
        .content h1 {
            color: #28a745;
        }
        .content p {
            font-size: 1.2em;
            color: #333;
        }
        .content .child-details {
            margin-top: 20px;
            font-size: 1.1em;
            line-height: 1.6;
        }
        .content .child-details span {
            font-weight: bold;
        }
        .content a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            color: white;
            background: #007bff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        .content a:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="content">
        <?php if ($adoption): ?>
            <h1>Adoption Successful!</h1>
            <p>Congratulations! You have successfully adopted a child.</p>
            <div class="child-details">
                <p><span>Child ID:</span> <?= htmlspecialchars($adoption['child_id']); ?></p>
                <p><span>Child Name:</span> <?= htmlspecialchars($adoption['child_name']); ?></p>
                <p><span>Date of Birth:</span> <?= htmlspecialchars($adoption['date_of_birth']); ?></p>
                <p><span>Special Needs:</span> <?= htmlspecialchars($adoption['disability'] === 'yes' ? 'Yes' : 'No'); ?></p>
                <p><span>Adoption Date:</span> <?= htmlspecialchars($adoption['date_assigned']); ?></p>
            </div>
        <?php else: ?>
            <h1>No Adoption Record Found</h1>
            <p>You have not successfully adopted any children yet.</p>
        <?php endif; ?>
        <a href="dashboard.php">Return to Dashboard</a>
    </div>
</body>
</html>

<?php
$conn->close();
?>

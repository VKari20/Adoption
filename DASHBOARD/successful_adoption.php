<?php
require_once 'connection.php';

// Fetch successful adoptions
$adoptions_query = "
    SELECT 
        m.match_id,
        p.full_name AS parent_name,
        p.home_address AS parent_address,
        c.full_name AS child_name,
        c.date_of_birth AS child_dob,
        c.disability AS child_special_needs,
        m.date_assigned AS adoption_date
    FROM 
        matches m
    INNER JOIN 
        prospective_parents p ON m.parent_id = p.parent_id
    INNER JOIN 
        children c ON m.child_id = c.child_id
    ORDER BY 
        m.date_assigned DESC";
$adoptions_result = $conn->query($adoptions_query);

if (!$adoptions_result) {
    die("Error fetching adoptions: " . $conn->error);
}

include "nav/header.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Successful Adoptions</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            margin: 0;
            display: flex;
            min-height: 100vh;
        }
      
        .content {
            flex-grow: 1;
            padding: 20px;
        }
        h1 {
            text-align: center;
        }
        table {
            border-collapse: collapse;
            width: 60%; /* Adjust table width */
            margin: 0 auto; /* Center align table */
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
            font-size: 0.9em; /* Reduce font size */
        }
        th {
            background-color: #f4f4f4;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>
   
    <div class="content">
        <h1 style="color:#f0a500">Successful Adoptions</h1>
        <?php if ($adoptions_result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Match ID</th>
                        <th>Parent Name</th>
                        <th>Parent Address</th>
                        <th>Child Name</th>
                        <th>Child Date of Birth</th>
                        <th>Special Needs</th>
                        <th>Adoption Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($adoption = $adoptions_result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($adoption['match_id']); ?></td>
                            <td><?= htmlspecialchars($adoption['parent_name']); ?></td>
                            <td><?= htmlspecialchars($adoption['parent_address']); ?></td>
                            <td><?= htmlspecialchars($adoption['child_name']); ?></td>
                            <td><?= htmlspecialchars($adoption['child_dob']); ?></td>
                            <td><?= htmlspecialchars($adoption['child_special_needs'] === 'yes' ? 'Yes' : 'No'); ?></td>
                            <td><?= htmlspecialchars($adoption['adoption_date']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p style="text-align: center;">No successful adoptions to display.</p>
        <?php endif; ?>
    </div>
    <!-- Download Report Button -->
<div style="text-align: center; margin-bottom: 20px;">
    <form action="download_report.php" method="POST">
        <button type="submit" name="download_report" style="padding: 10px 20px; background-color: #f0a500; color: white; border: none; cursor: pointer;">
            Download Report
        </button>
    </form>
</div>

</body>
</html>

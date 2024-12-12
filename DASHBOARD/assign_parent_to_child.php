<?php
require_once 'connection.php';

// Reusable function to fetch data
function fetchData($query, $conn) {
    $result = $conn->query($query);
    if (!$result) {
        die("Database query failed: " . $conn->error);
    }
    return $result;
}

// Fetch children available for adoption
$children_query = "SELECT * FROM children WHERE status = 'available for adoption'";
$children_result = fetchData($children_query, $conn);

// Fetch prospective parents who are not assigned to any child
$parents_query = "
    SELECT p.parent_id, p.full_name 
    FROM prospective_parents p 
    LEFT JOIN matches m ON p.parent_id = m.parent_id 
    WHERE p.status = 'accepted' AND m.parent_id IS NULL";
$parents_result = fetchData($parents_query, $conn);

// Handle form submission for matching
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['assign'])) {
    $parent_id = $_POST['parent_id'];
    $child_id = $_POST['child_id'];

    // Validate: Check if the child is already adopted
    $validation_query = "SELECT status FROM children WHERE child_id = ?";
    $stmt = $conn->prepare($validation_query);
    $stmt->bind_param("i", $child_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $child = $result->fetch_assoc();

    if ($child && $child['status'] === 'adopted') {
        echo "<p style='color: red;'>Error: The selected child has already been adopted.</p>";
    } else {
        // Proceed with assigning parent to child
        $conn->begin_transaction(); // Start transaction
        try {
            $assign_query = "INSERT INTO matches (parent_id, child_id, date_assigned) VALUES (?, ?, NOW())";
            $stmt = $conn->prepare($assign_query);
            $stmt->bind_param("ii", $parent_id, $child_id);
            $stmt->execute();

            // Mark child as adopted
            $update_child_query = "UPDATE children SET status = 'adopted' WHERE child_id = ?";
            $stmt = $conn->prepare($update_child_query);
            $stmt->bind_param("i", $child_id);
            $stmt->execute();

            $conn->commit(); // Commit transaction
            echo "<p style='color: green;'>Parent successfully assigned to child!</p>";
        } catch (Exception $e) {
            $conn->rollback(); // Rollback on error
            echo "<p style='color: red;'>Error: Could not assign parent to child. " . $e->getMessage() . "</p>";
        }
    }
}
include "nav/header.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Parent to Child</title>
    <style>
        /* General Reset */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            min-height: 100vh;
            background-color: #f8f9fa;
        }

        .content {
            flex-grow: 1;
            padding: 20px;
        }

        h1, h2 {
            color: #343a40;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin: 20px 0;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #343a40;
            color: white;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        form {
            background-color: white;
            padding: 20px;
            margin-top: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        select, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }

        button {
            background-color: #007BFF;
            color: white;
            cursor: pointer;
            font-weight: bold;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="content">
        <h1>Assign Parent to Child</h1>

        <h2 style="color:#f0a500">Available Children</h2>
        <table>
            <thead>
                <tr>
                    <th>Child ID</th>
                    <th>Full Name</th>
                    <th>Age</th>
                    <th>Special Needs</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($child = $children_result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($child['child_id']); ?></td>
                        <td><?= htmlspecialchars($child['full_name']); ?></td>
                        <td>
                            <?php
                            $dob = new DateTime($child['date_of_birth']);
                            $now = new DateTime();
                            $age = $now->diff($dob)->y;
                            echo $age;
                            ?>
                        </td>
                        <td><?= htmlspecialchars($child['disability'] === 'yes' ? 'Yes' : 'No'); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <form method="POST">
            <h2>Assign Parent to Child</h2>
            <label for="parent_id">Select Parent:</label>
            <select name="parent_id" id="parent_id" required>
                <?php
                if ($parents_result->num_rows > 0):
                    while ($parent = $parents_result->fetch_assoc()): ?>
                        <option value="<?= htmlspecialchars($parent['parent_id']); ?>">
                            <?= htmlspecialchars($parent['full_name']); ?>
                        </option>
                    <?php endwhile;
                else: ?>
                    <option disabled>No eligible parents available</option>
                <?php endif; ?>
            </select>

            <label for="child_id">Select Child:</label>
            <select name="child_id" id="child_id" required>
                <?php
                $children_result = fetchData($children_query, $conn); // Refresh result set
                while ($child = $children_result->fetch_assoc()): ?>
                    <option value="<?= htmlspecialchars($child['child_id']); ?>">
                        <?= htmlspecialchars($child['full_name']); ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <button type="submit" name="assign">Assign</button>
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>

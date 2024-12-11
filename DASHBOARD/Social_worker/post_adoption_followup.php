<?php
session_start();
// Database connection
$host = 'localhost';
$dbname = 'adoption';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        $child_id = $_POST['child_id'];
        $parent_id = $_POST['parent_id'];
        $followup_date = $_POST['followup_date'];
        $followup_status = $_POST['followup_status'];
        $followup_notes = $_POST['followup_notes'];
        $next_followup_date = $_POST['next_followup_date'];

        $stmt = $pdo->prepare("INSERT INTO post_adoption_followup (child_id, parent_id, followup_date, followup_status, followup_notes, next_followup_date) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$child_id, $parent_id, $followup_date, $followup_status, $followup_notes, $next_followup_date]);

    } elseif (isset($_POST['update'])) {
        $followup_id = $_POST['followup_id'];
        $child_id = $_POST['child_id'];
        $parent_id = $_POST['parent_id'];
        $followup_date = $_POST['followup_date'];
        $followup_status = $_POST['followup_status'];
        $followup_notes = $_POST['followup_notes'];
        $next_followup_date = $_POST['next_followup_date'];

        $stmt = $pdo->prepare("UPDATE post_adoption_followup SET child_id=?, parent_id=?, followup_date=?, followup_status=?, followup_notes=?, next_followup_date=? WHERE followup_id=?");
        $stmt->execute([$child_id, $parent_id, $followup_date, $followup_status, $followup_notes, $next_followup_date, $followup_id]);

    } elseif (isset($_POST['delete'])) {
        $followup_id = $_POST['followup_id'];

        $stmt = $pdo->prepare("DELETE FROM post_adoption_followup WHERE followup_id=?");
        $stmt->execute([$followup_id]);
    }
}

// Fetch follow-up records
$followups = $pdo->query("SELECT * FROM post_adoption_followup")->fetchAll(PDO::FETCH_ASSOC);

include "nav/nav.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Adoption Follow-Up</title>
    <style>
        /* General Styles */
body {
    font-family: Arial, sans-serif;
    background-color: #f9f9f9;
    margin: 0;
    padding: 0;
    line-height: 1.6;
}

h1 {
    text-align: center;
    color: #333;
    margin-top: 20px;
}

h2 {
    color: #444;
    margin-bottom: 10px;
}

/* Form Styling */
form {
    background: #fff;
    margin: 20px auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    width: 90%;
    max-width: 600px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

form label {
    display: block;
    margin-bottom: 8px;
    color: #555;
}

form input[type="number"],
form input[type="date"],
form input[type="text"],
form textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
}

form button {
    background-color: #28a745;
    color: #fff;
    border: none;
    padding: 10px 15px;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    margin-right: 5px;
}

form button:hover {
    background-color: #218838;
}

/* Table Styling */
table {
    width: 90%;
    margin: 20px auto;
    border-collapse: collapse;
    background: #fff;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

table th, table td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: center;
    color: #555;
}

table th {
    background-color: #f4f4f4;
    font-weight: bold;
}

table tr:nth-child(even) {
    background-color: #f9f9f9;
}

table tr:hover {
    background-color: #f1f1f1;
}

/* Button Styles in Table */
table form button {
    background-color: #dc3545;
    padding: 5px 10px;
    font-size: 14px;
}

table form button:hover {
    background-color: #c82333;
}

    </style>
</head>
<body>
    <h1>Post Adoption Follow-Up</h1>
    <a href="download_post_adoption_followup.php" class="btn btn-success">Download Report</a>

    <form method="POST">
        <h2>Add / Update Follow-Up</h2>
        <input type="hidden" name="followup_id" id="followup_id">
        <label>Child ID: <input type="number" name="child_id" required></label><br>
        <label>Parent ID: <input type="number" name="parent_id" required></label><br>
        <label>Follow-Up Date: <input type="date" name="followup_date" required></label><br>
        <label>Status: <input type="text" name="followup_status" required></label><br>
        <label>Notes: <textarea name="followup_notes" required></textarea></label><br>
        <label>Next Follow-Up Date: <input type="date" name="next_followup_date" required></label><br>
        <button type="submit" name="add">Add Follow-Up</button>
        <button type="submit" name="update">Update Follow-Up</button>
    </form>

    <h2>Follow-Up Records</h2>
    <table border="1">
        <tr>
            <th>Follow-Up ID</th>
            <th>Child ID</th>
            <th>Parent ID</th>
            <th>Follow-Up Date</th>
            <th>Status</th>
            <th>Notes</th>
            <th>Next Follow-Up Date</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($followups as $followup): ?>
            <tr>
                <td><?= htmlspecialchars($followup['followup_id']) ?></td>
                <td><?= htmlspecialchars($followup['child_id']) ?></td>
                <td><?= htmlspecialchars($followup['parent_id']) ?></td>
                <td><?= htmlspecialchars($followup['followup_date']) ?></td>
                <td><?= htmlspecialchars($followup['followup_status']) ?></td>
                <td><?= htmlspecialchars($followup['followup_notes']) ?></td>
                <td><?= htmlspecialchars($followup['next_followup_date']) ?></td>
                <td>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="followup_id" value="<?= htmlspecialchars($followup['followup_id']) ?>">
                        <button type="submit" name="delete">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>

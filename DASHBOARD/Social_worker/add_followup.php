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

// Fetch existing follow-up details
if (isset($_GET['followup_id'])) {
    $followup_id = $_GET['followup_id'];
    $stmt = $pdo->prepare("SELECT * FROM post_adoption_followup WHERE followup_id = ?");
    $stmt->execute([$followup_id]);
    $followup = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$followup) {
        die("Follow-up record not found.");
    }
} else {
    die("No follow-up ID provided.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $followup_id = $_POST['followup_id'];
    $child_id = $_POST['child_id'];
    $parent_id = $_POST['parent_id'];
    $followup_date = $_POST['followup_date'];
    $followup_status = $_POST['followup_status'];
    $followup_notes = $_POST['followup_notes'];
    $next_followup_date = $_POST['next_followup_date'];

    $stmt = $pdo->prepare("UPDATE post_adoption_followup SET child_id = ?, parent_id = ?, followup_date = ?, followup_status = ?, followup_notes = ?, next_followup_date = ? WHERE followup_id = ?");
    $stmt->execute([$child_id, $parent_id, $followup_date, $followup_status, $followup_notes, $next_followup_date, $followup_id]);

    echo "<script>alert('Follow-up updated successfully.'); window.location.href='followups.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Follow-Up</title>
</head>
<body>
    <h1>Update Follow-Up</h1>
    <form method="POST">
        <input type="hidden" name="followup_id" value="<?= htmlspecialchars($followup['followup_id']) ?>">
        <label>Child ID: <input type="number" name="child_id" value="<?= htmlspecialchars($followup['child_id']) ?>" required></label><br>
        <label>Parent ID: <input type="number" name="parent_id" value="<?= htmlspecialchars($followup['parent_id']) ?>" required></label><br>
        <label>Follow-Up Date: <input type="date" name="followup_date" value="<?= htmlspecialchars($followup['followup_date']) ?>" required></label><br>
        <label>Status: <input type="text" name="followup_status" value="<?= htmlspecialchars($followup['followup_status']) ?>" required></label><br>
        <label>Notes: <textarea name="followup_notes" required><?= htmlspecialchars($followup['followup_notes']) ?></textarea></label><br>
        <label>Next Follow-Up Date: <input type="date" name="next_followup_date" value="<?= htmlspecialchars($followup['next_followup_date']) ?>" required></label><br>
        <button type="submit">Update Follow-Up</button>
    </form>
</body>
</html>

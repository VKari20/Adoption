<?php
require_once 'connection.php'; // Import the database connection

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    $result = $conn->query("SELECT * FROM users WHERE user_id = $user_id");
    $user = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $role = $_POST['role'];

    $conn->query("UPDATE users SET username='$username', email='$email', phone_number='$phone_number', role='$role' WHERE user_id=$user_id");
    header("Location: manage_users.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit User</title>
</head>
<body>
  <form method="POST">
    <label>Username:</label>
    <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
    <label>Email:</label>
    <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
    <label>Phone Number:</label>
    <input type="text" name="phone_number" value="<?php echo htmlspecialchars($user['phone_number']); ?>" required>
    <label>Role:</label>
    <select name="role">
      <option value="admin" <?php if ($user['role'] == 'admin') echo 'selected'; ?>>Admin</option>
      <option value="orphanage staff" <?php if ($user['role'] == 'orphanage staff') echo 'selected'; ?>>Orphanage Staff</option>
      <option value="adoption agency" <?php if ($user['role'] == 'adoption agency') echo 'selected'; ?>>Adoption Agency</option>
      <option value="prospective parent" <?php if ($user['role'] == 'prospective parent') echo 'selected'; ?>>Prospective Parent</option>
    </select>
    <button type="submit">Update</button>
  </form>
</body>
</html>

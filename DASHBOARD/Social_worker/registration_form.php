<?php
session_start();

require_once 'connection.php'; // Import the database connection

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        // Check if username is already taken
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $error = "Username is already taken.";
            } else {
                // Hash the password
                $hashedPassword = password_hash(password: $password, PASSWORD_DEFAULT);

                // Assign a default role (e.g., 'user')
                $sql = "SELECT RoleID FROM role WHERE RoleName = 'user'";
                $roleResult = $conn->query($sql);
                if ($roleResult->num_rows > 0) {
                    $roleRow = $roleResult->fetch_assoc();
                    $userRoleID = $roleRow['RoleID'];
                } else {
                    // Create default 'user' role if not exists
                    $sql = "INSERT INTO role (RoleName, Description) VALUES ('user', 'Standard user role')";
                    $conn->query($sql);
                    $userRoleID = $conn->insert_id;
                }

                // Insert new user into the database
                $sql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                if ($stmt) {
                    $stmt->bind_param("ssi", $username, $hashedPassword, $userRoleID);
                    $stmt->execute();
                    $success = "Registration successful. You can now <a href='login.php'>log in</a>.";
                    $stmt->close();
                } else {
                    $error = "Error preparing the query: " . $conn->error;
                }
            }
        } else {
            $error = "Error preparing the query: " . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - OrphanConnect</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        #signup-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 16px;
            box-sizing: border-box;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background-color: #45a049; /* Darker green on hover */
        }

        .error {
            color: red;
            margin-bottom: 16px;
        }

        .success {
            color: green;
            margin-bottom: 16px;
        }
    </style>
</head>
<body>
<div id="signup-container">
    <h2>Sign Up for OrphanConnect</h2>
    <?php
    if (!empty($error)) {
        echo "<div class='error'>$error</div>";
    }
    if (!empty($success)) {
        echo "<div class='success'>$success</div>";
    }
    ?>
    <form action="registration_form.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required>

        <button type="submit">Sign Up</button>
    </form>
    <div class="text-center mt-3">
        <a href="login.php" class="d-block">Already have an account? Login here</a>
    </div>
</div>
</body>
</html>
<?php
// Ensure only admin can register users
//session_start();
//if ($_SESSION['role'] != 'admin') {
    //header('Location: login.php');
    //exit();
//}

// Handle registration logic here...
?>

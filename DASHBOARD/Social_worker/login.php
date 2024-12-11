<?php
session_start();

require_once 'connection.php'; // Import the database connection

$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $socialWorkerUsername = $_POST['username'];
    $socialWorkerPassword = $_POST['password'];

    // Check if the username exists in the database
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $socialWorkerUsername);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Fetch the user record
            $user = $result->fetch_assoc();

            // Verify the password
            if (password_verify($socialWorkerPassword, $user['password'])) {
                // Ensure user role is 'social worker'
                if ($user['role'] == 7) { // Assuming 7 is the RoleID for 'social worker'
                    // Password matches - set session variables
                    $_SESSION['social_worker_logged_in'] = true;
                    $_SESSION['social_worker_username'] = $socialWorkerUsername;
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['role'] = $user['role'];

                    // Redirect to social worker's dashboard
                    header("Location: index.php");
                    exit;
                } else {
                    $error = "You do not have social worker access.";
                }
            } else {
                // Incorrect password
                $error = "Invalid username or password.";
            }
        } else {
            // Username doesn't exist
            $error = "Invalid username or password.";
        }

        $stmt->close();
    } else {
        $error = "Error preparing the query: " . $conn->error;
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Social Worker Login</title>
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

        #login-container {
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
    </style>
</head>
<body>
<div id="login-container">
    <h2>Login to OrphanConnect</h2>
    <?php if (!empty($error)) { echo "<div class='error'>$error</div>"; } ?>
    <form action="login.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Login</button>
    </form>
    <div class="text-center mt-3">
        <a href="#" class="d-block">Forgot Password?</a>
        <a href="registration_form.php" class="d-block">Sign Up</a>
    </div>
</div>
</body>
</html>

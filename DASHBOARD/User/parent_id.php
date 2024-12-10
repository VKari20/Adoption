<?php 
session_start();
require_once 'connection.php'; // Import the database connection

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $full_name = $_POST['full_name'];
    $date_of_birth = $_POST['date_of_birth'];
    $home_address = $_POST['home_address'];
    $occupation = $_POST['occupation'];
    $marital_status = $_POST['marital_status'];
    $preferences = $_POST['preferences'];
    $user_id = $_SESSION['user_id']; // Retrieve the user ID from the session

    // Calculate the age
    $age = date_diff(date_create($date_of_birth), date_create('today'))->y;

    // Check if the age is within the allowed range
    if ($age < 25 || $age > 65) {
        echo "You must be between 25 and 65 years old to register.";
        exit;
    }

    // Insert into prospective_parents table
    $sql = "INSERT INTO prospective_parents (user_id, date_of_birth, full_name, home_address, occupation, marital_status, preferences, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, 'in-process')";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Prepare failed: " . $conn->error); // Debugging for SQL errors
    }

    // Bind parameters (ensure date_of_birth is in proper format YYYY-MM-DD)
    $stmt->bind_param("issssss", $user_id, $date_of_birth, $full_name, $home_address, $occupation, $marital_status, $preferences);

    if ($stmt->execute()) {
        // Retrieve the newly inserted parent_id
        $_SESSION['parent_id'] = $conn->insert_id;

        // Redirect to index.php after successful submission
        header("Location: index.php?message=Account successfully created&type=success");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="styless.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div id="parent-id-form" class="container mt-5">
    <h2 class="text-center">Parent Application Form</h2>
    <form method="POST" action="">
        <div class="form-group">
            <label for="full_name">Full Name:</label>
            <input type="text" id="full_name" name="full_name" class="form-control" placeholder="Full name" required>
        </div>
        <div class="form-group">
            <label for="date_of_birth">Date of Birth (YYYY-MM-DD):</label>
            <input type="" id="date_of_birth" name="date_of_birth" class="form-control" placeholder="Enter DoB(YYYY-MM-DD)" required>
        </div>
        <div class="form-group">
            <label for="home_address">Home Address:</label>
            <input type="text" id="home_address" name="home_address" class="form-control" placeholder="Home Address" required>
        </div>
        <div class="form-group">
            <label for="phone_number">Phone Number:</label>
            <input type="tel" id="phone_number" name="phone_number" class="form-control" 
                required pattern="^\+?[0-9]{1,4}?[-.\s\(\)]?(\(?\d{1,3}?\)?[-.\s]?)?[\d\s\.-]{3,4}[-.\s]?\d{3,4}$" 
                placeholder="Enter your phone number">
        </div>
        <div class="form-group">
            <label for="occupation">Occupation:</label>
            <input type="text" id="occupation" name="occupation" class="form-control" placeholder="Occupation">
        </div>
        <div class="form-group">
            <label for="marital_status">Marital Status:</label>
            <select id="marital_status" name="marital_status" class="form-control" required>
                <option value="single">Single</option>
                <option value="married">Married</option>
                <option value="divorced">Divorced</option>
                <option value="widowed">Widowed</option>
            </select>
        </div>
        <div class="form-group">
            <label for="preferences">Preferences (Optional):</label>
            <textarea id="preferences" name="preferences" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-primary btn-block btn-submit">Submit</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>

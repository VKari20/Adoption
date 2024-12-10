<?php
// Start session
session_start();

// Function to connect to the database
function getDatabaseConnection() {
    $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $dbname = "adoption";

    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

// Check if a submission message is available
$form_message = isset($_SESSION['form_submitted']) ? $_SESSION['form_submitted'] : null;
unset($_SESSION['form_submitted']); // Clear the session variable after use

// Retrieve parent details from the database if parent_id is set
$parent_id = $_SESSION['parent_id'] ?? null;

if ($parent_id) {
    $conn = getDatabaseConnection();
    
    // Fetch parent details from the database
    $sql = "SELECT * FROM prospective_parents WHERE parent_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $parent_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if parent details are found
    if ($result->num_rows > 0) {
        $parent_data = $result->fetch_assoc();
    } else {
        die("Parent data not found.");
    }

    // Check if a request already exists for the parent
    $request_exists = false;
    $sql_request_check = "SELECT * FROM adoption_requests WHERE parent_id = ? LIMIT 1";
    $stmt_request_check = $conn->prepare($sql_request_check);
    $stmt_request_check->bind_param("i", $parent_id);
    $stmt_request_check->execute();
    $request_result = $stmt_request_check->get_result();

    // If a request exists, set $request_exists to true
    if ($request_result->num_rows > 0) {
        $request_exists = true;
    }

    // Close the database connection
    $stmt->close();
    $stmt_request_check->close();
    $conn->close();
} else {
    die("Parent ID not found in session.");
}

// Check if the user has already submitted the form
if (isset($_SESSION['submitted']) && $_SESSION['submitted'] === true) {
    echo "<h2>You have already submitted your adoption application. Thank you!</h2>";
    exit;
}

include "nav/nav.php";

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


    <div class="form-container">
        <h2>Adoption Application</h2>

        <!-- Display the session message (if any) -->
        <?php if (isset($_SESSION['form_submitted'])): ?>
            <div class="alert alert-info">
                <?php
                echo htmlspecialchars($_SESSION['form_submitted']); // Display the message
                unset($_SESSION['form_submitted']); // Clear the message after displaying it
                ?>
            </div>
        <?php endif; ?>
        
        <?php if ($request_exists): ?>
            <p class="info">You have already submitted a request for adoption. Please contact support if you need to update your information.</p>
        <?php else: ?>

            <form action="submit_adoption_application.php" method="POST">
                <!-- Full Name -->
                <div class="form-group">
                    <label for="full_name">Full Name:</label>
                    <input type="text" id="full_name" name="full_name" class="form-control" 
                           value="<?php echo htmlspecialchars($parent_data['full_name']); ?>" readonly>
                </div>

                <!-- Home Address -->
                <div class="form-group">
                    <label for="home_address">Home Address:</label>
                    <input type="text" id="home_address" name="home_address" class="form-control" 
                           value="<?php echo htmlspecialchars($parent_data['home_address']); ?>" readonly>
                </div>
                <div class="form-group">
    <label for="date_of_birth">Date of Birth:</label>
    <input type="text" id="date_of_birth" name="date_of_birth" class="form-control" value="<?php echo htmlspecialchars($parent_data['date_of_birth']); ?>" readonly>
</div>

                <!-- Occupation -->
                <div class="form-group">
                    <label for="occupation">Occupation:</label>
                    <input type="text" id="occupation" name="occupation" class="form-control" 
                           value="<?php echo htmlspecialchars($parent_data['occupation']); ?>" readonly>
                </div>

                <!-- Marital Status -->
                <div class="form-group">
                    <label for="marital_status">Marital Status:</label>
                    <input type="text" id="marital_status" name="marital_status" class="form-control" 
                           value="<?php echo htmlspecialchars($parent_data['marital_status']); ?>" readonly>
                </div>

                <!-- Preferences -->
                <div class="form-group">
                    <label for="preferences">Preferences:</label>
                    <textarea id="preferences" name="preferences" class="form-control" readonly><?php echo htmlspecialchars($parent_data['preferences']); ?></textarea>
                </div>

                <!-- Child ID -->
                <div class="form-group">
                    <label for="child_id">Child ID (if specified):</label>
                    <input type="text" id="child_id" name="child_id" class="form-control" placeholder="Enter Child ID if known">
                </div>

                <!-- Additional Notes -->
                <div class="form-group">
                    <label for="additional_notes">Additional Notes:</label>
                    <textarea id="additional_notes" name="additional_notes" class="form-control" placeholder="Any other relevant information or preferences"></textarea>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary btn-block">Submit</button>
            </form>
        <?php endif; ?>
    </div>

  <!-- Include the footer -->
<?php include 'nav/footer.php'; ?>
</body>
</html>

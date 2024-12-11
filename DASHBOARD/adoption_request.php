<?php
session_start();

require_once 'connection.php'; // Import the database connection

// Check if parent_id is set in the session
if (!isset($_SESSION['parent_id'])) {
    die("Error: No parent ID found. Please log in again.");
}

$parent_id = $_SESSION['parent_id'];

// Check if the user has already submitted the form
$sql_check = "SELECT * FROM adoption_requests WHERE parent_id = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("i", $parent_id);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

// If a record exists, display the thank-you message
if ($result_check->num_rows > 0) {
    echo '<div class="thanks-container">';
    echo '<h2>Thank you for your submission!</h2>';
    echo '<p>Your adoption request has been successfully submitted. Our team will review it and get back to you shortly.</p>';
    echo '<a href="thank_you_page.php" class="btn btn-primary">Go to Dashboard</a>';
    echo '</div>';
} else {
    // Fetch parent details from the database
    $sql = "SELECT * FROM prospective_parents WHERE parent_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $parent_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a record was found
    if ($result->num_rows > 0) {
        $parent_data = $result->fetch_assoc();
    } else {
        $parent_data = null;
    }

    include "nav/nav.php";
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Child Adoption Request Form</title>
    <link rel="stylesheet" href="styless.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Thank You Message Container */
        .thanks-container {
            background-color: #eaf7e0; /* Light green background for a positive, welcoming feel */
            padding: 40px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            text-align: center;
        }

        /* Thank You Header */
        .thanks-container h2 {
            font-size: 30px;
            color: #007bff; /* Blue color for the title */
            margin-bottom: 20px;
            font-weight: bold;
        }

        /* Thank You Paragraph */
        .thanks-container p {
            font-size: 18px;
            color: #333;
            margin-bottom: 30px;
        }

        /* Button to go back to the dashboard */
        .thanks-container a {
            display: inline-block;
            padding: 12px 30px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        /* Hover effect for the button */
        .thanks-container a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
    <body>
        <!-- Form Container -->
        <div class="form-container">
            <h2>Child Adoption Request Form</h2>
            <?php if ($parent_data): ?>
                <form action="submit_request.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="full_name">Full Name:</label>
                        <input type="text" id="full_name" name="full_name" class="form-control" value="<?php echo htmlspecialchars($parent_data['full_name']); ?>" readonly>
                    </div>
                       <div class="form-group">
    <label for="date_of_birth">Date of Birth:</label>
    <input type="text" id="date_of_birth" name="date_of_birth" class="form-control" value="<?php echo htmlspecialchars($parent_data['date_of_birth']); ?>" readonly>
</div>
                    <div class="form-group">
                        <label for="home_address">Home Address:</label>
                        <input type="text" id="home_address" name="home_address" class="form-control" value="<?php echo htmlspecialchars($parent_data['home_address']); ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="occupation">Occupation:</label>
                        <input type="text" id="occupation" name="occupation" class="form-control" value="<?php echo htmlspecialchars($parent_data['occupation']); ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="marital_status">Marital Status:</label>
                        <input type="text" id="marital_status" name="marital_status" class="form-control" value="<?php echo htmlspecialchars($parent_data['marital_status']); ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="preferences">Preferences:</label>
                        <textarea id="preferences" name="preferences" class="form-control" readonly><?php echo htmlspecialchars($parent_data['preferences']); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="adopter_email">Email:</label>
                        <input type="email" id="adopter_email" name="adopter_email" required>
                    </div>
                    <div class="form-group">
                        <label for="contact_number">Contact Number:</label>
                        <input type="text" id="contact_number" name="contact_number" required>
                    </div>
                    <div class="form-group">
                        <label for="national_id_number">National ID Number:</label>
                        <input type="text" id="national_id_number" name="national_id_number" required>
                    </div>
                    <div class="form-group">
                        <label for="annual_income">Annual Income:</label>
                        <input type="number" id="annual_income" name="annual_income" required>
                    </div>
                    <div class="form-group">
                        <label for="picture">Picture:</label>
                        <input type="file" id="picture" name="picture" required>
                    </div>
                    <div class="form-group">
                        <label for="code_of_conduct">Code of Conduct:</label>
                        <input type="file" id="code_of_conduct" name="code_of_conduct" required>
                    </div>
                    <div class="form-group">
                        <label for="additional_notes">Additional Notes:</label>
                        <textarea id="additional_notes" name="additional_notes" class="form-control" placeholder="Any other relevant information or preferences"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block btn-submit">Submit</button>
                </form>
            <?php else: ?>
                <p class="alert alert-warning">No data found for this parent. Please contact support.</p>
            <?php endif; ?>
        </div>
        <!-- Footer -->
        <?php include "nav/footer.php"; ?>
    </body>
    </html>
    <?php
}
// Close the connection
$conn->close();
?>

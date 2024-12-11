<?php
session_start();

require_once 'connection.php'; // Import the database connection

// Check if parent_id is set in the session
if (!isset($_SESSION['parent_id'])) {
    die("Error: No parent ID found. Please log in again.");
}

$parent_id = $_SESSION['parent_id'];

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

include "nav/nav.php"; // Include navigation

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Study Application</title>
    <link rel="stylesheet" href="styless.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Style for the form */
        .form-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 30px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .btn-submit {
            width: 100%;
        }
    </style>
</head>
<body>

    <!-- Form Container -->
    <div class="form-container">
        <h2>Home Study Application Form</h2>
        <?php if ($parent_data): ?>
            <form action="submit_home_study.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="full_name">Full Name:</label>
                    <input type="text" id="full_name" name="full_name" class="form-control" value="<?php echo htmlspecialchars($parent_data['full_name']); ?>" readonly>
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
                <!-- New Fields for Home Study -->
                <div class="form-group">
                    <label for="email">Email Address:</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Email" required>
                </div>
                <div class="form-group">
                    <label for="contact_number">Contact Number:</label>
                    <input type="text" id="contact_number" name="contact_number" class="form-control" placeholder="Contact number" required>
                </div>

                <div class="form-group">
                    <label for="health_status">Health Status:</label>
                    <textarea id="health_status" name="health_status" class="form-control" placeholder="Describe your health status (if any relevant medical history)"></textarea>
                </div>
                <div class="form-group">
                    <label for="annual_income">Annual Income:</label>
                    <input type="number" id="annual_income" name="annual_income" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="references">References (personal or professional):</label>
                    <textarea id="references" name="references" class="form-control" placeholder="Provide at least two references (name and contact)"></textarea>
                </div>
                <div class="form-group">
                    <label for="criminal_record">Do you have any criminal record?</label>
                    <select id="criminal_record" name="criminal_record" class="form-control" placeholder="Do you have a criminal record?" required>
                        <option value="no">No</option>
                        <option value="yes">Yes</option>
                    </select>
                </div>
                <div class="form-group">
                        <label for="code_of_conduct">Code of Conduct:</label>
                        <input type="file" id="code_of_conduct" name="code_of_conduct" required>
                    </div>
                <div class="form-group">
                    <label for="adopt_reason">Why do you want to adopt a child?</label>
                    <textarea id="adopt_reason" name="adopt_reason" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <label for="additional_notes">Additional Notes:</label>
                    <textarea id="additional_notes" name="additional_notes" class="form-control" placeholder="Any other relevant information or preferences"></textarea>
                </div>
                <button type="submit" class="btn btn-primary btn-block btn-submit">Submit Home Study Application</button>
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
// Close the connection
$conn->close();
?>

<?php
require_once 'connection.php'; // Import the database connection

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Collect and sanitize input data
        $full_name = $conn->real_escape_string($_POST['full_name']);
        $date_of_birth = $conn->real_escape_string($_POST['date_of_birth']);
        $gender = $conn->real_escape_string($_POST['gender']);
        $blood_group = $conn->real_escape_string($_POST['blood_group']);
        $date_found = $conn->real_escape_string($_POST['date_found']);
        $city_found = $conn->real_escape_string($_POST['city_found']);
        $education_level = $conn->real_escape_string($_POST['education_level']);
        $current_orphanage_id = $conn->real_escape_string($_POST['current_orphanage_id']);
        $disability = $conn->real_escape_string($_POST['disability']);
        $allergies = $conn->real_escape_string($_POST['allergies']);
        $disability_description = $conn->real_escape_string($_POST['disability_description']);
        $notes = $conn->real_escape_string($_POST['notes']);
        $status = 'available for adoption'; // default status for new children

        // Image upload handling
        $target_dir = "uploads/";

        // Check if the uploads directory exists, create if it does not
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        // Generate a unique name for the image file
        $image_name = time() . '_' . bin2hex(random_bytes(5)) . '.' . pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
        $target_file = $target_dir . $image_name;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image_path = $target_file;
        } else {
            throw new Exception("Failed to upload image.");
        }

        // Insert data into children table
        $sql = "INSERT INTO children (
                    full_name, date_of_birth, gender, blood_group, 
                    image_path, date_found, city_found, education_level, 
                    current_orphanage_id, disability, allergies, 
                    disability_description, notes, status
                ) VALUES (
                    '$full_name', '$date_of_birth', '$gender', '$blood_group',
                    '$image_path', '$date_found', '$city_found', '$education_level', 
                    '$current_orphanage_id', '$disability', '$allergies', 
                    '$disability_description', '$notes', '$status'
                )";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('New child added successfully!');</script>";
            echo "<script>window.location.href='manage_kids.php';</script>"; // Redirect to child.php
            exit;
        } else {
            throw new Exception("Error adding child: " . $conn->error);
        }
    } catch (Exception $e) {
        echo "<script>alert('".$e->getMessage()."');</script>";
    }
}

$conn->close();
?>

<?php
session_start();

// Check if parent_id is set in the session
if (!isset($_SESSION['parent_id'])) {
    die("Error: No parent ID found. Please log in again.");
}

require_once 'connection.php'; // Import the database connection

$parent_id = $_SESSION['parent_id'];

// Fetch the latest adoption request status for the parent
$sql = "SELECT adoption_request_number, status FROM adoption_requests WHERE parent_id = ? ORDER BY created_at DESC LIMIT 1";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("SQL Error: " . $conn->error);
}
$stmt->bind_param("i", $parent_id);
$stmt->execute();
$stmt->bind_result($adoption_request_number, $status);
$stmt->fetch();
$stmt->close();


// If no adoption request is found, display a relevant message
if (empty($adoption_request_number)) {
    $message = "No adoption request found for this user.";
    $adoption_request_number = "N/A";
    $status = "N/A";
} else {
    $message = "Thank you for your adoption request!";
}

// Check if the user wants to download the message as a PDF
if (isset($_GET['download']) && $_GET['download'] === 'pdf') {
    require_once 'tcpdf/tcpdf.php'; // Include the TCPDF library

    // Create new PDF document
    $pdf = new TCPDF();

    // Set document information
    $pdf->SetCreator('Adoption System');
    $pdf->SetAuthor('Adoption System');
    $pdf->SetTitle('Thank You Message');
    $pdf->SetSubject('Adoption Request Details');

    // Set default header data
    $pdf->SetHeaderData('', 0, 'Thank You', 'Adoption Request Details');

    // Set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // Set margins
    $pdf->SetMargins(15, 27, 15);
    $pdf->SetHeaderMargin(5);
    $pdf->SetFooterMargin(10);

    // Add a page
    $pdf->AddPage();

    // Add content
    $html = "
    <h1>Thank You</h1>
    <p>$message</p>
    <p><strong>Your Adoption Request Number:</strong> $adoption_request_number</p>
    <p><strong>Status:</strong> $status</p>
    ";

    $pdf->writeHTML($html, true, false, true, false, '');

    // Output the PDF as a download
    $pdf->Output('Thank_You_Message.pdf', 'D');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f9f9f9;
        }

        .thank-you-container {
            text-align: center;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .thank-you-container h1 {
            color: #4caf50;
            font-size: 2.5rem;
        }

        .thank-you-container p {
            font-size: 1.2rem;
            color: #555555;
            margin: 20px 0;
        }

        .thank-you-container .request-number, .thank-you-container .status {
            font-weight: bold;
            color: #333333;
            margin: 15px 0;
        }

        .thank-you-container a {
            display: inline-block;
            padding: 10px 20px;
            font-size: 1rem;
            color: #ffffff;
            background-color: #4caf50;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .thank-you-container a:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="thank-you-container">
        <h1><?php echo htmlspecialchars($message); ?></h1>
        <p class="request-number">Your Adoption Request Number: <span><?php echo htmlspecialchars($adoption_request_number); ?></span></p>
        <p class="status">Status: <span><?php echo htmlspecialchars($status); ?></span></p>
        <a href="index.php">Return to Dashboard</a>
        <a class="download-link" href="?download=pdf">Download as PDF</a>
    </div>
</body>
</html>

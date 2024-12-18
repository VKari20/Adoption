<?php
ob_start();
require_once 'connection.php';
require_once 'tcpdf/tcpdf.php';

// Disable custom header
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->setPrintHeader(false); // Disable the header to avoid issues temporarily
$pdf->SetTitle('Prospective Parents Report');
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 10);

// Sample Content
$pdf->Write(0, 'This is the report of prospective parents.');
$pdf->Output('Prospective_Parents_Report.pdf', 'D');
ob_end_clean();


// Check for database connection errors
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Create new PDF document
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Kids Adoption');
$pdf->SetTitle('Prospective Parents Report');
$pdf->SetSubject('Report');
$pdf->SetKeywords('TCPDF, PDF, Report, Prospective Parents');

// Set header and footer
$pdf->setHeaderData('', '', 'Prospective Parents Report', 'Generated by Kids Adoption');
$pdf->setFooterData();
$pdf->setHeaderFont(['helvetica', '', 12]);
$pdf->setFooterFont(['helvetica', '', 10]);

// Set margins
$pdf->SetMargins(15, 27, 15);
$pdf->SetHeaderMargin(5);
$pdf->SetFooterMargin(10);

// Add a page
$pdf->AddPage();

// Set font for content
$pdf->SetFont('helvetica', '', 10);
$pdf->Ln(5); // Add a small vertical space

// Add content title
$pdf->Cell(0, 10, 'List of Prospective Parents', 0, 1, 'C');

// Fetch data from database
$sql = "SELECT full_name, home_address, occupation, marital_status, preferences FROM prospective_parents";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    // Create a table for the PDF
    $pdf->Ln(10); // Add spacing before the table
    $pdf->SetFillColor(224, 235, 255); // Table header background color
    $pdf->SetFont('', 'B');
    $pdf->Cell(10, 7, '#', 1, 0, 'C', 1);
    $pdf->Cell(50, 7, 'Full Name', 1, 0, 'C', 1);
    $pdf->Cell(50, 7, 'Home Address', 1, 0, 'C', 1);
    $pdf->Cell(30, 7, 'Occupation', 1, 0, 'C', 1);
    $pdf->Cell(20, 7, 'Status', 1, 0, 'C', 1);
    $pdf->Cell(30, 7, 'Preferences', 1, 1, 'C', 1);

    $pdf->SetFont('', '');
    $counter = 1;
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(10, 7, $counter++, 1);
        $pdf->Cell(50, 7, $row['full_name'], 1);
        $pdf->Cell(50, 7, $row['home_address'], 1);
        $pdf->Cell(30, 7, $row['occupation'], 1);
        $pdf->Cell(20, 7, $row['marital_status'], 1);
        $pdf->Cell(30, 7, $row['preferences'], 1, 1);
    }
} else {
    // If no data is found, display a message
    $pdf->Ln(10);
    $pdf->Write(0, 'No prospective parents found.');
}

// Close the database connection
$conn->close();

// Output PDF to browser for download
ob_end_clean(); // Clear the buffer
$pdf->Output('Prospective_Parents_Report.pdf', 'D');
?>

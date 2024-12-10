<?php
// Database connection details
$host = 'localhost';     // Database host
$db = 'adoption'; // Database name
$user = 'root';          // Database username (default for XAMPP)
$pass = '';              // Database password (default for XAMPP)

try {
    // Create a PDO instance for database connection
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Catch connection errors
    die("Connection failed: " . $e->getMessage());
}
?>

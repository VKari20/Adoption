<?php
// Enable error reporting for debugging (optional, can be removed in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start the session
session_start();

// Destroy all session variables
session_unset();

// Destroy the session
session_destroy();

// Prevent caching of this page
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// Redirect the user to the login page (or homepage or any other page)
header("Location: ../DASHBOARD/index.php"); // Change 'login.php' to your actual login page
exit();
?>

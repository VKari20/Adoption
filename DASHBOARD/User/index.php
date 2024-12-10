
<?php
require_once 'connection.php'; // Import the database connection
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
<body>

   <!-- Welcome Text Container -->
   <div class="welcome-container">
   <?php
        // Check if a message is passed via query string
        if (isset($_GET['message']) && isset($_GET['type'])) {
            $message = htmlspecialchars($_GET['message']); // Sanitize input
            $type = htmlspecialchars($_GET['type']); // Sanitize input
            
            // Set appropriate alert class based on type
            $alertClass = ($type == 'success') ? 'alert-success' : 'alert-danger';
            echo "<div class='alert $alertClass text-center' role='alert'>$message</div>";
        }
        ?>
        <img src="Images/photo7.jpg" alt="Welcome Image">
        <div class="text">
            <h2>Welcome to OrphanConnect!!</h2>
            <p>We're glad to have you here. Explore our services and make a difference in the lives of children in need. Feel free to navigate through the portal for adoption applications, viewing available children, and more!</p>
       
        </div>
    </div>

    <script>
        // Toggle Sidebar
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            sidebar.classList.toggle('open');
        }
       
    </script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>


<?php include "nav/footer.php"; ?>
    </body>
</html>
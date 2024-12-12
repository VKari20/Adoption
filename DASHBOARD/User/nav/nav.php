
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User OrphanConnect</title>
    <link rel="stylesheet" href="styless.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">

<style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            width: 250px;
            background-color: #343a40;
            color: white;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
        }

        .sidebar .logo {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .sidebar .logo img {
            margin-right: 10px;
            width: 50px;
            height: 50px;
        }

        .sidebar h4 {
            color: white;
            font-size: 24px;
            margin: 0;
        }

        .sidebar .MyPortal {
            text-align: center;
            margin: 30px 0;
        }

        .sidebar nav ul {
            list-style-type: none;
            padding: 0;
        }

        .sidebar nav ul li a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px 0;
            font-size: 18px;
        }

        .sidebar nav ul li a:hover {
            background-color: #495057;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="logo">
            <img src="Images/O.logo.png" alt="Logo" height="50px" width="50px">
            <h4 style="color:white">OrphanConnect</h4>
        </div>
        <div class="MyPortal">
            <i class="fa fa-user fa-5x"></i>
            <h3 style="color:#FCFC1F">My Portal</h3>
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Dashboard</a></li>
                <li><a href="home_study_application.php">Home Study Application</a></li>
                <li><a href="adoption_request.php">Adoption Request</a></li>
                <li><a href="adoption_success.php">View Adoption</a></li>
                <li><a href="post_adoption_followup.php"></a>
                <li><a href="logout.php">Log Out</a></li>
            </ul>
        </nav>
    </div>
     <!-- Hamburger Menu Icon -->
 <div class="hamburger" onclick="toggleSidebar()">
        <div></div>
        <div></div>
        <div></div>
    </div>
    <script>
        // Toggle Sidebar
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            sidebar.classList.toggle('open');
        }
       
    </script>

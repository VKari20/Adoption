<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SWorker Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        /* Additional styles for layout */
        .navbar {
            z-index: 1;
            position: sticky;
            top: 0;
        }

        .container-fluid {
            padding: 0;
        }

        .row.no-gutters {
            margin: 0;
        }

        #sidebar {
            background-color: #343a40;
            min-height: 100vh;
        }

        .sidebar-sticky {
            position: sticky;
            top: 0;
        }

        .sidebar .nav-link {
            color: #ffffff;
        }

        .sidebar .nav-link:hover {
            color: #adb5bd;
        }

        main {
            padding: 20px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-dark">
        <a class="navbar-brand" href="index.php">
            <img src="image/image.png" alt="logo" height="30">
            ORPHANCONNECT KENYA
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fa fa-bell"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fa fa-envelope"></i></a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row no-gutters">
            <!-- Sidebar -->
            <nav id="sidebar" class="col-md-2 d-none d-md-block bg-dark sidebar">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>" href="index.php">
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'manage_kids.php' ? 'active' : ''; ?>" href="manage_kids.php">Manage Child</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'manage_parents.php' ? 'active' : ''; ?>" href="manage_parents.php">Manage Parents</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'all_adoption_requests.php' || basename($_SERVER['PHP_SELF']) == 'new_adoption_request.php' || basename($_SERVER['PHP_SELF']) == 'accepted_requests.php' || basename($_SERVER['PHP_SELF']) == 'rejected_requests.php' ? 'active' : ''; ?>" data-toggle="collapse" href="#collapseAdoption" role="button" aria-expanded="false" aria-controls="collapseAdoption">
                                Home Study Approvals
                            </a>
                            <div class="collapse" id="collapseAdoption">
                                <ul class="nav flex-column ml-3">
                                    <li class="nav-item">
                                        <a class="nav-link" href="all_requests.php">All Requests</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="new_adoption_request.php">New Requests</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="accepted_requests.php">Accepted Requests</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="rejected_requests.php">Rejected Requests</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'post_adoption_followup.php' ? 'active' : ''; ?>" href="post_adoption_followup.php">Post Adoption Followup</a>
                        </li>
                       <!-- <li class="nav-item">
                            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'reports.php' ? 'active' : ''; ?>" href="reports.php">Reports and Documentation</a>
                        </li>-->
                    </ul>
                </div>
            </nav>

            <!-- Main Content Area -->
            <main class="col-md-10 ml-sm-auto px-4">
                <!-- Page content will be dynamically loaded here -->

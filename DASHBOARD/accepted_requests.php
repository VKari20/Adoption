<?php
require_once 'connection.php'; // Import the database connection

// Fetch only accepted adoption requests
$sql = "SELECT id, adoption_request_number, adopter_name, adopter_email, contact_number, status 
        FROM adoption_requests 
        WHERE status = 'accepted'";
$result = $conn->query($sql);

// Close the connection after fetching data
$conn->close();

include "nav/header.php";
?>

<!-- Main Content -->
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Accepted Adoption Requests</h1>
    </div>
    <body>
    <div class="container mt-5">
        <h2 class="mb-4">Accepted Requests</h2>

        <?php if ($result->num_rows > 0): ?>
            <table id="adoptionRequests" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Adoption Request Number</th>
                        <th>Adopter Name</th>
                        <th>Adopter Email</th>
                        <th>Contact Number</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $s_no = 1; // To display serial numbers
                    while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $s_no++; ?></td>
                            <td><?= htmlspecialchars($row["adoption_request_number"]); ?></td>
                            <td><?= htmlspecialchars($row["adopter_name"]); ?></td>
                            <td><?= htmlspecialchars($row["adopter_email"]); ?></td>
                            <td><?= htmlspecialchars($row["contact_number"]); ?></td>
                            <td><span class="badge bg-success"><?= htmlspecialchars($row["status"]); ?></span></td>
                            <td>
                                <a href="view_request.php?id=<?= $row["id"]; ?>" class="btn btn-info"><i class="fa fa-eye"></i> View</a>
                                <a href="reject_request.php?id=<?= $row["id"]; ?>" class="btn btn-danger"><i class="fa fa-times"></i> Reject</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="alert alert-info text-center">No accepted adoption requests found.</p>
        <?php endif; ?>
    </div>

    <!-- Initialize DataTable -->
    <script>
        $(document).ready(function() {
            $('#adoptionRequests').DataTable();
        });
    </script>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <span class="text-muted">© 2024 OrphanConnect by Vennesa</span>
        </div>
    </footer>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</body>
</html>

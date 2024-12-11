<?php
// Start session and connect to the database
session_start();

require_once 'connection.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from the database
$sql = "SELECT 
            c.child_id, 
            c.full_name, 
            c.date_of_birth, 
            c.gender, 
            c.education_level, 
            o.orphanage_name AS current_orphanage, 
            c.status,
            c.blood_group
        FROM children AS c
        LEFT JOIN orphanages AS o ON c.current_orphanage_id = o.orphanage_id";

$result = $conn->query($sql);

include "nav/nav.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Kids</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
</head>
<body>

<!-- Main Content -->
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      <h1 class="h2">Manage Kids</h1>
      <a href="download_kids_report.php" class="btn btn-success">Download Report</a>
    </div>
    <div class="table-responsive">
        <table id="manageKidsTable" class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Full Name</th>
                    <th>Date of Birth</th>
                    <th>Gender</th>
                    <th>Education Level</th>
                    <th>Current Orphanage</th>
                    <th>Blood Group</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Display children data
                if ($result->num_rows > 0) {
                    $count = 1;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr id='kid_" . $row['child_id'] . "'>";
                        echo "<td>" . $count . "</td>";
                        echo "<td>" . htmlspecialchars($row['full_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['date_of_birth']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['gender']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['education_level']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['current_orphanage']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['blood_group']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                        echo "<td><button class='btn btn-info' onclick='viewKid(" . $row['child_id'] . ")'>View</button></td>";
                        echo "</tr>";
                        $count++;
                    }
                } else {
                    echo "<tr><td colspan='9'>No records found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- View Modal -->
<div class="modal fade" id="viewKidModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">View Kid</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <input type="hidden" id="viewKidId">
                    <div class="form-group">
                        <label for="viewFullName">Full Name</label>
                        <input type="text" class="form-control" id="viewFullName" readonly>
                    </div>
                    <div class="form-group">
                        <label for="viewDateOfBirth">Date of Birth</label>
                        <input type="text" class="form-control" id="viewDateOfBirth" readonly>
                    </div>
                    <div class="form-group">
                        <label for="viewGender">Gender</label>
                        <input type="text" class="form-control" id="viewGender" readonly>
                    </div>
                    <div class="form-group">
                        <label for="viewEducationLevel">Education Level</label>
                        <input type="text" class="form-control" id="viewEducationLevel" readonly>
                    </div>
                    <div class="form-group">
                        <label for="viewCurrentOrphanage">Current Orphanage</label>
                        <input type="text" class="form-control" id="viewCurrentOrphanage" readonly>
                    </div>
                    <div class="form-group">
                        <label for="viewBloodGroup">Blood Group</label>
                        <input type="text" class="form-control" id="viewBloodGroup" readonly>
                    </div>
                    <div class="form-group">
                        <label for="viewStatus">Status</label>
                        <input type="text" class="form-control" id="viewStatus" readonly>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function () {
        $('#manageKidsTable').DataTable();
    });

    function viewKid(childId) {
        $.ajax({
            url: 'get_kid.php',
            type: 'POST',
            data: { child_id: childId },
            success: function (response) {
                try {
                    const kid = JSON.parse(response);
                    if (kid.error) {
                        alert(kid.error);
                        return;
                    }
                    $('#viewKidId').val(kid.child_id);
                    $('#viewFullName').val(kid.full_name);
                    $('#viewDateOfBirth').val(kid.date_of_birth);
                    $('#viewGender').val(kid.gender);
                    $('#viewEducationLevel').val(kid.education_level);
                    $('#viewCurrentOrphanage').val(kid.current_orphanage);
                    $('#viewBloodGroup').val(kid.blood_group);
                    $('#viewStatus').val(kid.status);
                    $('#viewKidModal').modal('show');
                } catch (e) {
                    console.error(e);
                    alert("An error occurred.");
                }
            },
            error: function () {
                alert("Failed to fetch data. Please try again.");
            }
        });
    }
</script>
</body>
</html>
<?php $conn->close(); ?>

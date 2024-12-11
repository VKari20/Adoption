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

include "nav/header.php";

// Function to calculate age
function calculateAge($dob) {
    $birthDate = new DateTime($dob);
    $today = new DateTime('today');
    $age = $birthDate->diff($today)->y;
    return $age;
}
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
                    <th>Age</th>
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
                        $age = calculateAge($row['date_of_birth']); // Calculate age
                        echo "<tr id='kid_" . $row['child_id'] . "'>";
                        echo "<td>" . $count . "</td>";
                        echo "<td>" . htmlspecialchars($row['full_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['date_of_birth']) . "</td>";
                        echo "<td>" . $age . "</td>"; // Display age
                        echo "<td>" . htmlspecialchars($row['gender']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['education_level']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['current_orphanage']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['blood_group']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                        echo "<td>
                                <button class='btn btn-info' onclick='editKid(" . $row['child_id'] . ")'>Edit</button>
                                <button class='btn btn-danger' onclick='deleteKid(" . $row['child_id'] . ")'>Delete</button>
                              </td>";
                        echo "</tr>";
                        $count++;
                    }
                } else {
                    echo "<tr><td colspan='10'>No records found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</main>

<!-- Edit Modal -->
<div class="modal fade" id="editKidModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Kid</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editKidForm">
                    <input type="hidden" id="editKidId">
                    <div class="form-group">
                        <label for="editFullName">Full Name</label>
                        <input type="text" class="form-control" id="editFullName" required>
                    </div>
                    <div class="form-group">
                        <label for="editDateOfBirth">Date of Birth</label>
                        <input type="date" class="form-control" id="editDateOfBirth" required>
                    </div>
                    <div class="form-group">
                        <label for="editGender">Gender</label>
                        <select class="form-control" id="editGender" required>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="editEducationLevel">Education Level</label>
                        <input type="text" class="form-control" id="editEducationLevel" required>
                    </div>
                    <div class="form-group">
                        <label for="editCurrentOrphanage">Current Orphanage</label>
                        <input type="text" class="form-control" id="editCurrentOrphanage" required>
                    </div>
                    <div class="form-group">
                        <label for="editBloodGroup">Blood Group</label>
                        <input type="text" class="form-control" id="editBloodGroup" required>
                    </div>
                    <div class="form-group">
                        <label for="editStatus">Status</label>
                        <input type="text" class="form-control" id="editStatus" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
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

    // Function to edit kid's details
    function editKid(childId) {
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
                    $('#editKidId').val(kid.child_id);
                    $('#editFullName').val(kid.full_name);
                    $('#editDateOfBirth').val(kid.date_of_birth);
                    $('#editGender').val(kid.gender);
                    $('#editEducationLevel').val(kid.education_level);
                    $('#editCurrentOrphanage').val(kid.current_orphanage);
                    $('#editBloodGroup').val(kid.blood_group);
                    $('#editStatus').val(kid.status);
                    $('#editKidModal').modal('show');
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

    // Handle form submission for editing
    $('#editKidForm').on('submit', function (e) {
        e.preventDefault(); // Prevent the form from submitting normally

        const kidData = {
            child_id: $('#editKidId').val(),
            full_name: $('#editFullName').val(),
            date_of_birth: $('#editDateOfBirth').val(),
            gender: $('#editGender').val(),
            education_level: $('#editEducationLevel').val(),
            current_orphanage: $('#editCurrentOrphanage').val(),
            blood_group: $('#editBloodGroup').val(),
            status: $('#editStatus').val()
        };

        $.ajax({
            url: 'update_kid.php',
            type: 'POST',
            data: kidData,
            success: function (response) {
                alert("Kid information updated successfully!");
                $('#editKidModal').modal('hide');
                location.reload(); // Reload the page to reflect the changes
            },
            error: function () {
                alert("Failed to update data. Please try again.");
            }
        });
    });

    // Function to delete a kid record
    function deleteKid(childId) {
        if (confirm("Are you sure you want to delete this record?")) {
            $.ajax({
                url: 'delete_kid.php',
                type: 'POST',
                data: { child_id: childId },
                success: function (response) {
                    alert("Kid record deleted successfully!");
                    $('#kid_' + childId).remove(); // Remove the row from the table
                },
                error: function () {
                    alert("Failed to delete data. Please try again.");
                }
            });
        }
    }
</script>

</body>
</html>

<?php
$conn->close();
?>

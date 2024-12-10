<?php
require_once 'connection.php'; // Import the database connection

// SQL query to fetch child details along with orphanage name
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
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
</head>
<body>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Manage Kids</h1>
  <a href="download_kids_report.php" class="btn btn-success">Download Report</a>
  </div>
  <div class="container">
    <div class="table-responsive">
      <table id="manageKidsTable" class="table table-striped table-hover">
        <thead>
          <tr>
            <th>#</th>
            <th>Full Name</th>
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
        // Fetch and display children from the database
        $result = $conn->query("SELECT * FROM children");
        while ($row = $result->fetch_assoc()) {
            echo "<tr id='kid_{$row['child_id']}'>
                    <td>{$row['full_name']}</td>
                    <td>{$row['gender']}</td>
                    <td>{$row['education_level']}</td>
                    <td>{$row['blood_group']}</td>
                    <td>{$row['status']}</td>
                    <td>
                        <button class='btn btn-warning edit-btn' onclick='editKid({$row['child_id']})'>Edit</button>
                        <button class='btn btn-danger delete-btn' onclick='deleteKid({$row['child_id']})'>Delete</button>
                    </td>
                  </tr>";
                  
        }
        ?> 
        </tbody>
      </table>
    </div>
  </div>
</main>

<!-- Edit Modal for Kid -->
<div class="modal fade" id="editKidModal" tabindex="-1" role="dialog" aria-labelledby="editKidModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editKidModalLabel">Edit Kid</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
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
            <label for="editEducationLevel">Education Level</label>
            <input type="text" class="form-control" id="editEducationLevel" required>
          </div>
          <div class="form-group">
            <label for="editGender">Gender</label>
            <select class="form-control" id="editGender">
              <option value="male">Male</option>
              <option value="female">Female</option>
            </select>
          </div>
          <div class="form-group">
            <label for="editStatus">Status</label>
            <input type="text" class="form-control" id="editStatus" required>
          </div>
          <div class="form-group">
            <label for="editBloodGroup">Blood Group</label>
            <input type="text" class="form-control" id="editBloodGroup" required>
          </div>
          <button type="button" class="btn btn-primary" onclick="saveKidChanges()">Save Changes</button>
        </form>
      </div>
    </div>
  </div>
</div>

<footer>
        <p>&copy; 2024 Kids Adoption. All rights reserved.</p>
    </footer>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<script>
  $(document).ready(function () {
    $('#manageKidsTable').DataTable();
  });

  function editKid(childId) {
    $.ajax({
      url: 'get_kid.php',
      type: 'POST',
      data: { child_id: childId },
      success: function(response) {
        const kid = JSON.parse(response);
        $('#editKidId').val(kid.child_id);
        $('#editFullName').val(kid.full_name);
        $('#editEducationLevel').val(kid.education_level);
        $('#editGender').val(kid.gender);
        $('#editStatus').val(kid.status);
        $('#editBloodGroup').val(kid.blood_group);
        $('#editKidModal').modal('show');
      }
    });
  }

  function saveKidChanges() {
    const childId = $('#editKidId').val();
    const fullName = $('#editFullName').val();
    const educationLevel = $('#editEducationLevel').val();
    const gender = $('#editGender').val();
    const status = $('#editStatus').val();
    const bloodGroup = $('#editBloodGroup').val();

    $.ajax({
      url: 'update_kid.php',
      type: 'POST',
      data: {
        child_id: childId,
        full_name: fullName,
        education_level: educationLevel,
        gender: gender,
        status: status,
        blood_group: bloodGroup
      },
      success: function(response) {
        if (response === 'success') {
          $('#editKidModal').modal('hide');
          const row = $('#kid_' + childId);
          row.find('td:eq(1)').text(fullName);
          row.find('td:eq(3)').text(gender);
          row.find('td:eq(4)').text(educationLevel);
          row.find('td:eq(5)').text(bloodGroup);
          row.find('td:eq(6)').text(status);
          alert('Kid updated successfully');
        } else {
          alert('Failed to update kid: ' + response);
        }
      },
      error: function(xhr, status, error) {
        alert('AJAX Error: ' + error);
      }
    });
  }

  function deleteKid(childId) {
    if (confirm('Are you sure you want to delete this kid?')) {
      $.ajax({
        url: 'delete_kid.php',
        type: 'POST',
        data: { child_id: childId },
        success: function(response) {
          if (response === 'success') {
            $('#kid_' + childId).remove();
            alert('Kid deleted successfully');
        } else {
          alert('Failed to delete kid');
        }
      },
      error: function(xhr, status, error) {
        alert('AJAX Error: ' + error);
      }
    });
  }
}
</script>
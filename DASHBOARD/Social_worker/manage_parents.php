<?php
require_once 'connection.php'; // Import the database connection

include "nav/nav.php"; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Prospective Parents</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <!-- DataTables CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
</head>
<body>

  <!-- Main Content -->
  <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      <h1 class="h2">Manage Prospective Parents</h1>
      <a href="download_parents_report.php" class="btn btn-success">Download Report</a>
    </div>
    <div class="container">
      <div class="table-responsive">
        <table id="manageUsersTable" class="table table-striped table-hover">
          <thead>
            <tr>
              <th>#</th>
              <th>Full Name</th>
              <th>Home Address</th>
              <th>Occupation</th>
              <th>Marital Status</th>
              <th>Home Study Status</th>
              <th>Preferences</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            // Query to fetch prospective parents data
            $sql = "SELECT parent_id, user_id, full_name, home_address, occupation, marital_status, home_study_status, preferences, status FROM prospective_parents";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $count = 1;
                while ($row = $result->fetch_assoc()) {
                    echo "<tr id='parent_" . $row['parent_id'] . "'>";
                    echo "<td>" . $count . "</td>";
                    echo "<td>" . htmlspecialchars($row['full_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['home_address']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['occupation']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['marital_status']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['home_study_status']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['preferences']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                    echo "<td>
                            <button class='btn btn-info' onclick='viewParent(" . $row['parent_id'] . ")'>View</button>
                          </td>";
                    echo "</tr>";
                    $count++;
                }
            } else {
                echo "<tr><td colspan='9'>No prospective parents found</td></tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </main>

  <!-- View Modal -->
  <div class="modal fade" id="viewParentModal" tabindex="-1" role="dialog" aria-labelledby="viewParentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="viewParentModalLabel">View Prospective Parent</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="viewParentForm">
            <input type="hidden" id="viewParentId">
            <div class="form-group">
              <label for="viewFullName">Full Name</label>
              <input type="text" class="form-control" id="viewFullName" readonly>
            </div>
            <div class="form-group">
              <label for="viewHomeAddress">Home Address</label>
              <input type="text" class="form-control" id="viewHomeAddress" readonly>
            </div>
            <div class="form-group">
              <label for="viewOccupation">Occupation</label>
              <input type="text" class="form-control" id="viewOccupation" readonly>
            </div>
            <div class="form-group">
              <label for="viewMaritalStatus">Marital Status</label>
              <input type="text" class="form-control" id="viewMaritalStatus" readonly>
            </div>
            <div class="form-group">
              <label for="viewHomeStudyStatus">Home Study Status</label>
              <input type="text" class="form-control" id="viewHomeStudyStatus" readonly>
            </div>
            <div class="form-group">
              <label for="viewPreferences">Preferences</label>
              <input type="text" class="form-control" id="viewPreferences" readonly>
            </div>
            <div class="form-group">
              <label for="viewStatus">Status</label>
              <input type="text" class="form-control" id="viewStatus" readonly>
            </div>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <footer>
        <p>&copy; 2024 Kids Adoption. All rights reserved.</p>
    </footer>

  <!-- jQuery, DataTables, and Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

  <script>
    $(document).ready(function () {
      $('#manageUsersTable').DataTable();
    });

    // Populate modal with parent data for viewing
    function viewParent(parentId) {
      $.ajax({
        url: 'get_parent.php',
        type: 'POST',
        data: { parent_id: parentId },
        success: function (response) {
          const parent = JSON.parse(response);
          $('#viewParentId').val(parent.parent_id);
          $('#viewFullName').val(parent.full_name);
          $('#viewHomeAddress').val(parent.home_address);
          $('#viewOccupation').val(parent.occupation);
          $('#viewMaritalStatus').val(parent.marital_status);
          $('#viewHomeStudyStatus').val(parent.home_study_status);
          $('#viewPreferences').val(parent.preferences);
          $('#viewStatus').val(parent.status);
          $('#viewParentModal').modal('show');
        }
      });
    }
  </script>
</body>
</html>

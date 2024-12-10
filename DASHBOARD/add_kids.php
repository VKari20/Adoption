<?php
require_once 'connection.php'; // Import the database connection

include "nav/header.php"

?>


            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom"
          >
            <h1 class="h2">Add Kids</h1>
          </div>
    <div class="col-12 grid-margin stretch-card">
                <div class="card">
                <div class="card-body">
    <h4 class="card-title">New Kids Form</h4>
    <p class="card-description">Please fill out the form below to add a new child</p>
   
    <!-- Form for adding new child -->
    <form id="addChildForm" class="forms-sample" action="add_child.php" method="POST" enctype="multipart/form-data" onsubmit="return confirmSubmit();">

        <div class="form-group">
            <label for="exampleInputName1">Full Name</label>
            <input type="text" name="full_name" class="form-control" id="exampleInputName1" placeholder="Full Name" required>
        </div>

        <div class="form-group">
            <label for="dateOfBirth">Date of Birth</label>
            <input type="date" name="date_of_birth" class="form-control" id="dateOfBirth" required>
        </div>

        <div class="form-group">
            <label for="exampleSelectGender">Gender</label>
            <select name="gender" class="form-control" id="exampleSelectGender" required>
                <option value="">Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>
        </div>

        <div class="form-group">
            <label for="examplebloodgroup">Blood Group</label>
            <select name="blood_group" class="form-control" id="examplebloodgroup" required>
                <option value="">Select Blood Group</option>
                <option value="A+">A+</option>
                <option value="A-">A-</option>
                <option value="B+">B+</option>
                <option value="B-">B-</option>
                <option value="AB+">AB+</option>
                <option value="AB-">AB-</option>
                <option value="O+">O+</option>
                <option value="O-">O-</option>
            </select>
        </div>

        <div class="form-group">
            <label>Image Upload</label>
            <input type="file" name="image" class="file-upload-default" required>
        </div>

        <div class="form-group">
            <label for="dateFound">Date Found</label>
            <input type="date" name="date_found" class="form-control" id="dateFound" required>
        </div>

        <div class="form-group">
            <label for="exampleInputCity1">City/Place Found</label>
            <input type="text" name="city_found" class="form-control" id="exampleInputCity1" placeholder="Location" required>
        </div>

        <div class="form-group">
            <label for="currentOrphanage">Current Orphanage</label>
            <select name="current_orphanage_id" class="form-control" id="currentOrphanage" required>
                <option value="">Select Orphanage</option>
                <?php
                // PHP code to fetch orphanages from the database
                $conn = new mysqli("localhost", "root", "", "adoption");
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                $result = $conn->query("SELECT orphanage_id, orphanage_name FROM orphanages");
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['orphanage_id'] . "'>" . $row['orphanage_name'] . "</option>";
                }
                $conn->close();
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="educationLevel">Education Level</label>
            <select name="education_level" class="form-control" id="educationLevel" required>
                <option value="">Select Education Level</option>
                <option value="Early Childhood Education">Early Childhood Education</option>
                <option value="Primary School">Primary School</option>
                <option value="Secondary School">Secondary School</option>
               
            </select>
        </div>

        <div class="form-group">
            <label for="exampledisability">Disability</label>
            <select name="disability" class="form-control" id="exampledisability" required>
                <option value="">Select Disability</option>
                <option value="yes">Yes</option>
                <option value="no">No</option>
            </select>
        </div>

        <div class="form-group">
            <label for="exampleallergy">Allergies</label>
            <select name="allergies" class="form-control" id="exampleSelectAllergy" required>
                <option value="">Select Allergies</option>
                <option value="yes">Yes</option>
                <option value="no">No</option>
            </select>
        </div>

        <div class="form-group">
            <label for="exampledisabilityDescription">If Yes, Describe Disability</label>
            <input type="text" name="disability_description" class="form-control" id="exampledisabilityDescription" placeholder="Disability" required>
        </div>

        <div class="form-group">
            <label for="exampleTextarea1">Additional Notes</label>
            <textarea name="notes" class="form-control" id="exampleTextarea1" rows="4"></textarea>
        </div>

        <button type="submit" class="btn btn-primary mr-2">Add Child</button>
        <button type="reset" class="btn btn-light">Cancel</button>
    </form>
   

    <!-- JavaScript for confirmation alert -->
    <script>
        function confirmSubmit() {
            return confirm("Are you sure you want to add this child?");
        }
    </script>
</div>

                </div>
              </div>
              </main>
            </div>
          </div>
     <footer>
        <p>&copy; 2024 Kids Adoption. All rights reserved.</p>
    </footer>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script>
    $(document).ready(function () {
        $('#submitBtn').on('click', function () {
            $.ajax({
                url: 'add_child.php',
                type: 'POST',
                data: {
                    name: $('#name').val(),
                    gender: $('#gender').val(),
                    age: $('#age').val(),
                    blood_group: $('#blood_group').val(),
                    location: $('#location').val(),
                },
                success: function (response) {
                    if (response === 'success') {
                        alert('Added successfully');
                    } else {
                        alert('Error: ' + response);
                    }
                },
                error: function () {
                    alert('Error in AJAX request');
                }
            });
        });
    });
</script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<style>
  .scrollable-container {
    max-height: 500px; /* Adjust this height as needed */
    overflow-y: auto; /* Enable vertical scrolling */
    padding: 15px; /* Optional: add padding for a cleaner look */
    border: 1px solid #ddd; /* Optional: add border for separation */
}

</style>
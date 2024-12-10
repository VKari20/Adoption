<?php 
require_once 'connection.php'; // Import the database connection

$sql = "SELECT child_id, full_name, date_of_birth, gender, medical_history, psychological_history, 
        education_level, status, image_path FROM kids";
$result = $conn->query($sql);

include "nav/nav.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Kids</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="content-wrapper">
    <h2 class="section-title">View Available Kids for Adoption</h2>
    <section class="kids-grid" id="kids-grid">
        <!-- Kids profiles will be dynamically inserted here -->
    </section>
</div>

<script>
    // Function to toggle sidebar
    function toggleSidebar() {
        const sidebar = document.querySelector('.sidebar');
        const content = document.querySelector('.content-wrapper');
        sidebar.classList.toggle('open');
        content.classList.toggle('shifted');
    }

    // Function to fetch and display kids' data
    async function loadChildren() {
        try {
            const response = await fetch('fetch_children.php');
            if (!response.ok) throw new Error('Failed to fetch children data.');

            const children = await response.json();
            const kidsGrid = document.getElementById('kids-grid');
            kidsGrid.innerHTML = ''; // Clear existing content

            children.forEach(child => {
                const childCard = document.createElement('div');
                childCard.className = 'child-card';

                childCard.innerHTML = `
                    <img src="${child.image_path || 'images/default.jpg'}" 
                         alt="Profile picture of ${child.full_name}" 
                         onerror="this.src='images/default.jpg'">
                    <h3>${child.full_name}</h3>
                    <p><strong>Date of Birth:</strong> ${new Date(child.date_of_birth).toLocaleDateString()}</p>
                    <p><strong>Gender:</strong> ${child.gender.charAt(0).toUpperCase() + child.gender.slice(1)}</p>
                    <p><strong>Education Level:</strong> ${child.education_level || 'N/A'}</p>
                    <p><strong>Medical History:</strong> ${child.medical_history || 'N/A'}</p>
                    <p><strong>Psychological History:</strong> ${child.psychological_history || 'N/A'}</p>
                    <p class="adoption-status ${child.status.replace(' ', '-').toLowerCase()}">
                        <strong>Status:</strong> ${child.status}
                    </p>
                `;
                kidsGrid.appendChild(childCard);
            });
        } catch (error) {
    console.error('Error loading children data:', error);
    document.getElementById('kids-grid').innerHTML = `
        <p style="text-align:center; color:red;">Failed to load kids' data: ${error.message}. Please try again later.</p>
    `;
}
    }

    // Load children on page load
    window.addEventListener('DOMContentLoaded', loadChildren);
</script>

<?php include "nav/footer.php"; ?>

<style>
body, html {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    background-color: #f9f9f9;
}

.content-wrapper {
    padding: 20px;
}

.section-title {
    font-size: 32px;
    text-align: center;
    margin-bottom: 20px;
}

/* Kids Grid Styles */
.kids-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    padding: 20px;
}

.child-card {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
    text-align: center;
    transition: transform 0.2s;
}

.child-card img {
    width: 100%;
    height: 180px;
    object-fit: cover;
    border-radius: 8px;
}

.child-card h3 {
    font-size: 20px;
    margin: 15px 0 5px;
    color: #333;
}

.child-card p {
    font-size: 16px;
    color: #666;
    margin: 5px 0;
}

.adoption-status {
    font-weight: bold;
}

.adoption-status.available-for-adoption {
    color: green;
}

.adoption-status.in-process {
    color: orange;
}

.adoption-status.adopted {
    color: red;
}

.child-card:hover {
    transform: scale(1.02);
}

.content {
    margin-left: 520px; /* Adjust according to your sidebar width */
    padding: 20px;
}
</style>
</body>
</html>

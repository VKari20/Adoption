<?php
// footer.php
?>
<footer class="footer">
    <div class="container">
        <span class="text-muted"> © 2024 Copyright: OrphanConnect</span>
    </div>
</footer>
<style>
    .footer {
        background-color: #343a40; /* Dark background matching sidebar */
        color: white; /* White text for contrast */
        padding: 10px 0; /* Add some padding for spacing */
        text-align: center; /* Center-align the footer text */
        position: relative; /* Relative positioning to allow flexibility */
        bottom: 0; /* Stick to the bottom */
        width: 100%; /* Full width to span across the page */
    }

    .footer .container {
        max-width: 1200px; /* Center the content within the footer */
        margin: 0 auto; /* Auto margin for centering */
        padding: 0 15px; /* Add some side padding for smaller screens */
    }

    .footer .text-muted {
        font-size: 14px; /* Smaller font for subtle footer text */
    }

    @media (max-width: 768px) {
        .footer {
            font-size: 12px; /* Reduce font size for smaller screens */
        }
    }
</style>
<script>
    // Add common scripts or sidebar toggling functionality
    function toggleSidebar() {
        const sidebar = document.querySelector('.sidebar');
        sidebar.classList.toggle('open');
    }
</script>
</body>
</html>

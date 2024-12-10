<?php include "nav/navbar.php"; ?>
<!DOCTYPE html>
<html lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OrphanConnect</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
</head>
<body>
    

    <div class="content-wrapper">
        <section id="about">
            <div class="two-column-container">
                <div class="image-container">
                    <img src="Image/photo2.jpg" alt="online">
                </div>
                <div class="text-container">
                    <h2><i class="fas fa-info-circle"></i> About ORPHANCONNECT</h2>
                    <p><b>OrphanConnect</b> is a comprehensive orphanage management system designed to streamline the operations of orphanages and foster effective adoption processes.</p> <p>By leveraging advanced technology, OrphanConnect ensures seamless management of children's records, adoption applications, donor information, and staff operations.</p>
<p> Its user-friendly platform promotes <i>transparency and accountability, </i>making it easier for orphanages to connect children with loving families. </p>
<p>With <b>OrphanConnect, </b>we aim to create a bridge between orphans in need of care and nurturing homes, empowering organizations to focus on their mission of providing love, support, and opportunities to every child.</p>
                    
                </div>
            </div>
        </section>
    </div>

    <script>
        const menuIcon = document.getElementById('menu-icon');
        const navLinks = document.getElementById('nav-links');

        menuIcon.addEventListener('click', () => {
            navLinks.classList.toggle('active');
        });
    </script>
    <?php include "nav/footer.php";?>
</body>
</html>

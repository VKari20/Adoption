<?php include "nav/navbar.php"; ?>
<head>
    <link rel="stylesheet" href="style.css">
</head>
        <body>
        <section class="mission-section">
            <div class="mission-content">
                <h2>Welcome to OrphanConnect</h2>
                <p>Our mission is to empower children in need by providing them with a loving, nurturing, and supportive environment. We work to build lasting connections and create opportunities for brighter futures.</p>
            </div>
        </section>
    </div>

    
        

       
    <style>
       
       .mission-content {
    position: relative;
    background: rgba(105, 101, 101, 0.8); /* Slightly more opaque background for better visibility */
    padding: 60px 40px; /* Increased padding for more space */
    border-radius: 10px; /* Keeps the rounded edges */
    max-width: 1000px; /* Increases the width of the container */
    margin: auto; /* Centers the content horizontally */
    text-align: center;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); /* Adds a subtle shadow for a polished look */
}

.mission-section {
    background: url('Image/photo2.jpg') no-repeat center center/cover;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    color: #333;
    padding: 0 20px;
}

/* Text on Image */
.mission-content {
    position: relative;
    background: rgba(250, 248, 248, 0.417); /* Transparent background for readability */
    padding: 40px;
    border-radius: 10px;
    max-width: 800px;
    margin: auto;
    text-align: center;
}

.mission-content h1 {
    font-size: 48px;
    margin-bottom: 20px;
}

.mission-content p {
    font-size: 20px;
    line-height: 1.6;
    max-width: 700px;
}

       
        



        /* Responsive Design */
        @media (max-width: 768px) {
            .mission-content h1 {
                font-size: 36px;
            }
            .mission-content p {
                font-size: 18px;
            }
        }
        
    </style>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <?php include "nav/footer.php"; ?>
</body>
</html>

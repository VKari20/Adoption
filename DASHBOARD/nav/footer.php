<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer</title>
    <style>
        /* General reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Footer styling */
        .footer {
            background-color: #333;
            color: #fff;
            padding: 20px 0;
            font-family: Arial, sans-serif;
        }

        .footer .social {
            background-color: #6c63ff;
            padding: 10px 0;
            text-align: center;
        }

        .footer .social a {
            color: #fff;
            margin: 0 10px;
            text-decoration: none;
            font-size: 1.2em;
        }

        .footer .container {
            display: flex;
            justify-content: space-between;
            padding: 20px;
        }

        .footer .container div {
            flex: 1;
            padding: 0 20px;
        }

        .footer h4 {
            font-size: 1.2em;
            margin-bottom: 10px;
            color: #bbb;
        }

        .footer p, .footer a {
            color: #ccc;
            font-size: 0.9em;
            text-decoration: none;
            line-height: 1.6;
        }

        .footer a:hover {
            color: #fff;
        }

        .footer .copy {
            text-align: center;
            padding: 10px;
            font-size: 0.8em;
            color: #bbb;
            background-color: #222;
        }

        /* Icons for social links */
        .footer i {
            margin-right: 8px;
        }
    </style>

 
         <footer class="footer">
        <!-- Social Links -->
        <div class="social">
            <span>Get connected with us on social networks:</span>
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-google"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
           
        </div>
        <div class="container">
            <div>
                <h4>OrphanConnect</h4>
                <p>Our mission is to empower children in need by providing them with a loving, nurturing, and supportive environment.</p>
            </div>
            
            <div>
                <h4>Useful Links</h4>
                <p><a href="../auth/">Your Account</a></p>
                <p><a href="index.php">Home</a></p>
                <p><a href="kids_corner.php">Kids corner</a></p>
                <p><a href="#">Terms and Conditions</a></p>
            </div>
            <div>
                <h4>Contact</h4>
                <p><i class="fas fa-map-marker-alt"></i> Nairobi, Kenya</p>
                <p><i class="fas fa-envelope"></i> orphanconnect.com</p>
                <p><i class="fas fa-phone"></i> + 254 788 234 023</p>
            </div>
        </div>

        <!-- Copyright -->
        <div class="copy">
            © 2024 Copyright: OrphanConnect
        </div>
    </footer>

    <!-- Font Awesome for icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>

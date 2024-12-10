<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign Up or Sign In</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css">

    <style>
        /* Alert styles */
        .alert {
            color: white;
            padding: 10px;
            margin: 15px 0;
            border-radius: 5px;
        }

        .success {
            background-color: #4CAF50;
        }

        .error {
            background-color: #f44336;
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="main">
        <!-- Modal Popup for Messages -->
        <div id="messageModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <p id="modalMessage"></p>
            </div>
        </div>

        <!-- PHP Logic to Determine Which Form to Show -->
        <?php
        // Default to showing the sign-up form
        $showSignIn = isset($_GET['formType']) && $_GET['formType'] === 'signIn';
        ?>

        <!-- Display alerts based on URL parameters -->
        <?php if (isset($_GET['message'])): ?>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    showMessage("<?php echo htmlspecialchars($_GET['message']); ?>");
                });
            </script>
        <?php endif; ?>

        <!-- Sign up form -->
        <section id="signupSection" class="signup" style="display: <?php echo $showSignIn ? 'none' : 'block'; ?>;">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-form">
                        <h2 class="form-title">Create an account</h2>
                        <form method="POST" class="register-form" id="register-form" action="config/register_parent.php">
                            <div class="form-group">
                                <label for="username"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="username" id="username" required placeholder="Username" />
                            </div>
                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-email"></i></label>
                                <input type="email" name="email" id="email" required placeholder="Your Email" />
                            </div>
                            <div class="form-group">
                                <label for="pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="password" id="pass" required placeholder="Password" />
                            </div>
                            <div class="form-group">
                                <label for="re-pass"><i class="zmdi zmdi-lock-outline"></i></label>
                                <input type="password" name="re_pass" id="re_pass" required placeholder="Repeat your password" />
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="agree-term" id="agree-term" class="agree-term"/>
                                <label for="agree-term" class="label-agree-term"><span><samp></samp></span> I agree to the <a href="#" class="term-service">Terms of Service</a></label>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="signup" id="signup" class="form-submit" value="Register" />
                            </div>
                        </form>
                    </div>
                    <div class="signup-image">
                        <figure><img src="images/signup-image.jpg" alt="sign up image"></figure>
                        <a href="#" class="signup-image-link" onclick="toggleForms('signIn')">I am already a member</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Sign in Form -->
        <section id="signinSection" class="sign-in" style="display: <?php echo $showSignIn ? 'block' : 'none'; ?>;">
            <div class="container">
                <div class="signin-content">
                    <div class="signin-image">
                        <figure><img src="images/signin-image.jpg" alt="sign in image"></figure>
                        <a href="#" class="signup-image-link" onclick="toggleForms('signUp')">Create an account</a>
                    </div>
                    <div class="signin-form">
                        <h2 class="form-title">Sign In</h2>
                        <form action="config/login_process.php" method="POST" class="register-form" id="login-form">
                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-email"></i></label>
                                <input type="email" name="email" id="email" required placeholder="Your Email" />
                            </div>
                            <div class="form-group">
                                <label for="your_pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="password" id="your_pass" required placeholder="Password" />
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="signin" id="signin" class="form-submit" value="Log in" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- JavaScript for toggling forms and displaying messages -->
    <script>
        function toggleForms(formType) {
            const signupSection = document.getElementById("signupSection");
            const signinSection = document.getElementById("signinSection");
            if (formType === "signIn") {
                signupSection.style.display = "none";
                signinSection.style.display = "block";
            } else {
                signupSection.style.display = "block";
                signinSection.style.display = "none";
            }
        }

        function showMessage(message) {
            document.getElementById("modalMessage").innerText = message;
            document.getElementById("messageModal").style.display = "block";
        }

        function closeModal() {
            document.getElementById("messageModal").style.display = "none";
        }
    </script>
    <!-- JS -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>
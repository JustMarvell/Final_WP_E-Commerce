<?php
session_start();
include_once '../../models/database_connector.php'; // include database connection file
include_once '../../controllers/authenticator.php'; // include authentication controller file
include_once '../../controllers/utils.php'; // include utility functions

// Create a new instance of the database connection
$db = new DatabaseConnector();
$db_conn = $db->GetConnection();

$auth = new authentication($db_conn); // Create a new instance of the authentication controller
$err_msg = ''; // Initialize error message variable

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Call the login function when the form is submitted
    $err_msg = $auth->login();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/logreg.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
</head>
<body>
    <div class="container" id="container">
        <div class="form-container sign-up-container">
            <form action="#">
                <!-- <img src="uploads/logos/Logo_1.png" alt="LOGO" class="logo"> -->
                <h1><span class="cl-orange">Vello</span>Store</h1>
                <!-- <div class="social-container">
                    <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
                    <a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
                </div> -->
                <h2>Sign <span class="cl-orange">Up</span></h2>
                <span class="tx-sm">Use your email for registration</span>
                <input type="text" placeholder="Name" />
                <input type="email" placeholder="Email" />
                <input type="password" placeholder="Password" />
                <button>Sign Up</button>
            </form>
        </div>
        <div class="form-container sign-in-container">
            <form action="logreg.php" method="POST">
                <!-- <img src="uploads/logos/Logo_1.png" alt="LOGO" class="logo"> -->
                <h1>Vello<span class="cl-blue">Store</span></h1>
                <!-- <div class="social-container">
                    <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
                    <a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
                </div> -->
                <h2><span class="cl-blue">Sign</span> In</h2>
                
                <?php if ($err_msg): ?>
                    <span class="tx-sm"><?php echo $err_msg; ?></span>
                <?php else : ?>
                    <span class="tx-sm">Enter your username and password</span>
                <?php endif; ?>

                <input type="text" name="username" placeholder="Username" required/>
                <input type="password" name="password" placeholder="Password" required/>

                <!-- <a href="#">Forgot your password?</a> -->
                <button type="submit" class="sign-in">Sign In</button>
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <img src="uploads/logos/Logo_2.png" alt="LOGO" class="logo">
                    <h1>Welcome Back!</h1>
                    <p>Click here to login with your account</p>
                    <button class="ghost" id="signIn">Sign In</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <img src="uploads/logos/Logo_2.png" alt="LOGO" class="logo">
                    <h1>Hello, Friend!</h1>
                    <p>Please enjoy your visit!</p>
                    <!-- <button class="ghost" id="signUp">Sign Up</button> -->
                </div>
            </div>
        </div>
    </div>

    <script>
        const signUpButton = document.getElementById('signUp');
        const signInButton = document.getElementById('signIn');
        const container = document.getElementById('container');
    
        signUpButton.addEventListener('click', () => {
            container.classList.add("right-panel-active");
        });
    
        signInButton.addEventListener('click', () => {
            container.classList.remove("right-panel-active");
        });
    </script>
</body>
</html>
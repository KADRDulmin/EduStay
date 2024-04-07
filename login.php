<?php
ob_start();

// Start the session
session_start();
require "functions/process.php";

// Check if the user is already logged in
if (isset($_SESSION['UserID'])) {
    // If logged in, redirect to a dashboard or home page
    header("Location: index.php");
    exit();
  }

$db = new Database();

if ($db->dbConnect()) {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <?php include('header.php'); ?>
        <br>
        <h1>WELCOME TO <br><span style="color: rgba(59, 181, 75, 1);">GREEN</span> ACCOMMODATION</h1>

        <meta charset="UTF-8">
        <title>Login - EduStay</title>
        <link rel="stylesheet" href="css/login.css">
        <style>
        </style>
    </head>

    <body>

        <div class="login-page">
            <div class="form">
                <div class="login-logo">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTx6QtxtngZsxa6YQsa80rQV3FJkIAxyuz1_xTH9axUi1pEZe0-MTmpKfNMHGxwNJgNsvo&usqp=CAU" alt="Logo">
                </div>
                <div class="social-login">
                    <button onclick="loginWithFacebook()" style="background-color: white; border: 1px solid black; color: black;">Login with Facebook</button>
                    <br>
                    <br>
                    <button onclick="loginWithFacebook()" style="background-color: white; border: 1px solid black; color: black;">Login with University Email</button>
                    <br>
                    <br>
                </div>
                <div class="social-login">
                </div>
                <br>
                <form class="register-form" action="process_student_registration.php" method="post">
                    <input type="text" placeholder="name" />
                    <input type="password" placeholder="password" />
                    <input type="text" placeholder="email address" />
                    <button>create</button>
                    <p class="message">Already registered? <a href="#">Sign In</a></p>
                </form>
                <form class="login-form" method="post">
                    <input type="text" placeholder="Email" name="email" />
                    <input type="password" placeholder="Password" name="password" />
                    <button type="submit">login</button>
                    <br>
                    <div class="errortext">
                        <?php
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            if (isset($_POST['email']) && isset($_POST['password'])) {
                                $email = $_POST['email'];
                                $password = $_POST['password'];
                                if ($db->logIn($email, $password)) {
                                    // Set session variables


                                    // Set a temporary session timeout
                                    $_SESSION['timeout'] = time() + 3600;
                                    header("Location: index.php");
                                    exit();
                                } else {
                                    echo $result;
                                }
                            } else {
                                echo "All fields are required";
                            }
                        }
                        ?>
                    </div>
                    <br>
                    <p class="message"><a href="#">Forgot Password?</a></p>
                    <p class="message">Not registered? <a href="signup.php">Create an account</a></p>
                </form>
            </div>
        </div>
        <?php include('footer.php'); ?>
    </body>

    </html>
<?php
} else {
    echo "Database Connection Error";
}
?>
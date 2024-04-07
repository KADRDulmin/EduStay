<?php
require "functions/process.php";

$db = new DataBase();
if ($db->dbConnect()) {

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>

        <meta charset="UTF-8">
        <title>landlord</title>
        <link rel="stylesheet" href="css/wardon.css">
        <style>
        </style>
    </head>

    <body>
        <?php include('header.php'); ?>

        <br>
        <h1>WELCOME TO <br><span style="color: rgba(59, 181, 75, 1);">GREEN</span> ACCOMMODATION</h1>


        <div class="sign-page">

            <div class="form">
                <div class="logo">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTx6QtxtngZsxa6YQsa80rQV3FJkIAxyuz1_xTH9axUi1pEZe0-MTmpKfNMHGxwNJgNsvo&usqp=CAU" alt="Logo">
                </div>

                <div class="social-sign">

                </div>
                <br>
                <form class="register-form" name="Login" action="" method="POST">
                    <input type="text" placeholder="First Name" name="firstname" />
                    <input type="text" placeholder="Last Name" name="lastname" />
                    <input type="email" placeholder="Email" name="email" />
                    <input type="password" placeholder="Password" name="password" />
                    <button type="submit">Signup As a Landloard</button>
                    <br>
                    <div class="errortext">

                        <?php
                        if (isset($_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['password'])) {
                            if (!empty($_POST['firstname']) && !empty($_POST['lastname']) && !empty($_POST['email']) && !empty($_POST['password'])) {
                                if ($db->signUp("landloard", $_POST['email'], $_POST['password'], $_POST['firstname'], $_POST['lastname'])) {
                                    echo "Sign Up Success";
                                    header("Location: login.php");
                                    exit; // Terminate script after redirect
                                } else {
                                    echo "Sign up Failed";
                                }
                            } else {
                                echo "All fields are required";
                            }
                        } else {
                            echo "All fields are required";
                        }

                        ?>
                    </div>
                    <br>

                </form>
            </div>
        </div>

    </body>

    </html>
<?php
    /* Close connection */
}
?>
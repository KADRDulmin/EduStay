<?php
// Start a session
session_start();
ob_start();
require "functions/process.php";

// Get the UserID from $_SESSION['UserID']



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('header.php'); ?>
    <br>
    <h1>WELCOME TO <br><span style="color: rgba(59, 181, 75, 1);">GREEN</span> ACCOMMODATION</h1>

    <meta charset="UTF-8">
    <title>Modern Flat Design Login Form Example</title>
    <link rel="stylesheet" href="css/webmaster.css">
    <style>
    </style>
</head>

<body>

    <div class="sign-page">

        <div class="hide" style="display: none;"><?php
                                                $db = new Database();

                                                if ($db->dbConnect()) {

                                                    $admin_access = $db->admin_access($id);
                                                    $landlord_access = $db->landlord_access($id);
                                                    $warden_access = $db->warden_access($id);
                                                    $student_access = $db->student_access($id);
                                                    $id = $_SESSION['UserID']; ?></div>

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
                <div class="form-select">
                    <div class="role_select">
                        <select name="role" class="form-control" id="validationCustom05" required>
                            <option selected disabled value="">Select Role:</option>
                            <!-- ACCESS CONTROL -->
                            <?php if ($admin_access === true) { ?>
                                <option value="student">Student</option>
                                <option value="landlord">Landlord</option>
                                <option value="warden">Warden</option>
                                <option value="admin">Admin</option>
                            <?php } ?>
                            <?php if ($warden_access === true || $landlord_access === true || $student_access === true) { ?>
                                <option value="student">Student</option>
                                <option value="landlord">Landlord</option>
                            <?php } else { ?>
                                <option value="student">Student</option>
                                <option value="landlord">Landlord</option>
                            <?php } ?>

                        </select>
                    </div>
                </div>


                <button>Add New User</button>
                <br>
                <?php
                                                    if (isset($_POST['role'], $_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['password'])) {
                                                        if (!empty($_POST['role'] && $_POST['firstname']) && !empty($_POST['lastname']) && !empty($_POST['email']) && !empty($_POST['password'])) {
                                                            if ($db->signUp($_POST['role'], $_POST['email'], $_POST['password'], $_POST['firstname'], $_POST['lastname'])) {
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
                <br>

            </form>
        </div>
    </div>
    <?php include('footer.php'); ?>

</body>

</html>
<?php
                                                    /* Close connection */
                                                }
?>
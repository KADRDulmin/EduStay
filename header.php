<?php


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>EduStay</title>
  <link rel="stylesheet" href="css/header.css">
  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

</head>

<body>
  <header>
    <a href="index.php" class="header-logo">EduStay</a>
    <div class="menu-toggle"></div>
    <div class="hidden" style="display:none">
      <?php
      // Get the UserID from $_SESSION['UserID']
      $id = $_SESSION['UserID'];
      $db = new Database();

      if ($db->dbConnect()) {

        $admin_access = $db->admin_access($id);
        $landlord_access = $db->landlord_access($id);
        $warden_access = $db->warden_access($id);
        $student_access = $db->student_access($id);
      ?>
    </div>
    <nav>
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="contact.php">Contact</a></li>

        <!-- ACCESS CONTROL -->
        <?php if ($admin_access === true || $warden_access === true) { ?>
          <li><a href="signup.php">Create User</a></li>
        <?php } ?>

        <?php if (!isset($_SESSION['UserID'])) { ?>
        <li><a href="login.php" class="login-button">Login</a></li>
        <?php } ?>
        <li>
          <form method="post" action="" style="margin: 8px 0 0 0;">
            <?php if (isset($_SESSION['UserID'])) { ?>
              <input type="submit" class="logout-button" name="logout" value="Logout"> <?php } ?>

            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['logout'])) {
              $db->Logoutbutton();
            }
            ?>
          </form>
        </li>

      </ul>
    </nav>
    <div class="clearfix"></div>
  </header>
  <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $('.menu-toggle').click(function() {
        $('.menu-toggle').toggleClass('active')
        $('nav').toggleClass('active')
      })
    })
  </script>
</body>

</html>
<?php
      }
      ob_end_flush();
?>
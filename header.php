
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Header</title>
  <link rel="stylesheet" href="css/header.css">
  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

</head>

<body>
  <header>
    <a href="index.php" class="header-logo">EduStay</a>
    <div class="menu-toggle"></div>
    <nav>
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="#">About</a></li>   
        <li><a href="#">Contact</a></li>
        <li><a href="login.php" class="login-button">Login</a></li>
        <li><form method="post" action="" style="margin: 8px 0 0 0;">
                <input type="submit" class="logout-button" name="logout" value="Logout">

                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['logout'])) {
                    $database = new DataBase();
                    $database->Logoutbutton();
                }
                ?>
            </form></li>

      </ul>
    </nav>
    <div class="clearfix"></div>
  </header>
   <script
  src="https://code.jquery.com/jquery-3.4.1.js"
  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
  crossorigin="anonymous"></script>
  <script type="text/javascript">
  $(document).ready(function(){
    $('.menu-toggle').click(function(){
    $('.menu-toggle').toggleClass('active')
  $('nav').toggleClass('active')
    })
  })</script>
</body>

</html>
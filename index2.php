<?php
// Start a session
session_start();
ob_start();


// Check if the user is not logged in, redirect to login.php
if (!isset($_SESSION['UserID'])) {
  header("Location: login.php");
  exit();
}
// Get the UserID from $_SESSION['UserID']
$ID = $_SESSION['UserID'];

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="This is a web to help the new students of NSBM to find accommodation around the university under the guidance of the warden. ">
    <meta name="author" content="Group DE Project">
    <link rel="icon" href="images/favicon.ico">

  <title>Book a Room - Edustay</title>

  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <!-- Toastr -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css" integrity="sha256-R91pD48xW+oHbpJYGn5xR0Q7tMhH4xOrWn1QqMRINtA=" crossorigin="anonymous" /> <!-- Custom styles for this template -->
  <!-- Custom styles for this template, generated by SASS -->
  <link href="css/style.css" rel="stylesheet">
  <!-- Links
    https://developers.google.com/maps/documentation/javascript/info-windows-to-db -->
</head>

<body>
  <?php include('header.php'); ?>


  <div class="dashboard-container">
    <main role="main">
      <div class="container-fluid">
        <div class="row mb-3 mt-3">
          <div class="col-12 col-xl-5">
            <!-- Navigation Tabs -->
            <nav>
              <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active" id="nav-new-tab" data-toggle="tab" href="#nav-new" role="tab" aria-controls="nav-new" aria-selected="true" onclick="loadAjax('new')">Add Location</a>
                <a class="nav-item nav-link" id="nav-edit-tab" data-toggle="tab" href="#nav-edit" role="tab" aria-controls="nav-edit" aria-selected="false" onclick="loadAjax('edit')">Modify Location</a>
              </div>
            </nav>
            <!-- Tabs content -->
            <div class="tab-content" id="nav-tabContent">
              <!-- Add new - page -->
              <div class="tab-pane fade show active pt-3 pb-3" id="nav-new" role="tabpanel" aria-labelledby="nav-new-tab">
                <h2>Add New Location: <?php echo $ID; ?></h2>
                <div id="addPlace"></div>
              </div>
              <!-- Edit / delete - page -->
              <div class="tab-pane fade pt-3 pb-3" id="nav-edit" role="tabpanel" aria-labelledby="nav-edit-tab">
                <h2>Modify Your Location:</h2>
                <div id="listPlaces"></div>
              </div>
            </div>
          </div>
          <div class="col-12 col-xl-7">
            <!-- Map container -->
            <div id="map"></div>
          </div>
        </div>
      </div>
    </main>
  </div>

  <?php include('footer.php'); ?>

  <!--JavaScripts-->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js" integrity="sha256-yNbKY1y6h2rbVcQtf0b8lq4a+xpktyFc3pSYoGAY1qQ=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.min.js"></script>

  <script src="scripts/scripts.js"></script>

  <!-- Google Maps JS API -->
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBleZ4eth9X_mKyb88UqQqYpIJwm05k-Iw"></script>
</body>

</html>
<?php
ob_end_flush();
?>
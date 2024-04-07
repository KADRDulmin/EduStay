<?php
// Start a session
session_start();
ob_start();
require "functions/process.php";


// Check if the user is not logged in, redirect to login.php
if (!isset($_SESSION['UserID'])) {
  header("Location: login.php");
  exit();
}
// Get the UserID from $_SESSION['UserID']
$id = $_SESSION['UserID'];
$db = new Database();

if ($db->dbConnect()) {

  $admin_access = $db->admin_access($id);
  $landlord_access = $db->landlord_access($id);
  $warden_access = $db->warden_access($id);
  $student_access = $db->student_access($id);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="css/contact.css">
</head>
<body>
<div class="background">
    <div class="container">
        <div class="screen">
            <div class="screen-header">
                <div class="screen-header-left">
                    
                </div>
                <div class="screen-header-right">
                    <div class="screen-header-ellipsis"></div>
                    <div class="screen-header-ellipsis"></div>
                    <div class="screen-header-ellipsis"></div>
                </div>
            </div>
            <div class="screen-body">
                <div class="screen-body-item left">
                    <div class="app-title">
					<img src="pTi68_7Y_400x400-removebg-preview.png" alt="Logo" class="logo" style="width: 300px; height: auto; display: block; margin: 0 auto;">


                        <span>CONTACT US</span>
                        
					<br>
					
                    <div class="app-contact">
        
					<p>Phone: +94 11 544 5000<span style="margin-left: 25px;"></span></p>
						 <div style="text-align: center; margin-left: 80px;">
    					<p>Address: Mahenwaththa, Pitipana, Homagama</p>
						</div>
						<p>Email: inquiries@nsbm.ac.lk</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
        <svg class="dribbble" viewBox="0 0 200 200">
            
                
                <path d="M62.737004,13.7923523 C105.08055,51.0454853 135.018754,126.906957 141.768278,182.963345" stroke-width="20"></path>
                <path d="M10.3787186,87.7261455 C41.7092324,90.9577894 125.850356,86.5317271 163.474536,38.7920951" stroke-width="20"></path>
                <path d="M41.3611549,163.928627 C62.9207607,117.659048 137.020642,86.7137169 189.041451,107.858103" stroke-width="20"></path>
            
        </svg>
    </a>
</div>
</div>
</body>
</html>
<?php
}
ob_end_flush();
?>

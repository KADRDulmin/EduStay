<!DOCTYPE html>
<html lang="en">
<head>
<?php include('header.php'); ?>
    <br>
    <h1>WELCOME TO <br><span style="color: rgba(59, 181, 75, 1);">GREEN</span> ACCOMMODATION</h1>

    <meta charset="UTF-8">
    <title>Signup - EduStay</title>
    <link rel="stylesheet" href="css/signup.css">
    <style>
        </style>
</head>
<body>


  <div class="sign-page">
  
    <div class="form">
        <div class="logo">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTx6QtxtngZsxa6YQsa80rQV3FJkIAxyuz1_xTH9axUi1pEZe0-MTmpKfNMHGxwNJgNsvo&usqp=CAU" alt="Logo">
        </div>
       
        <div class="social-sign">
            
        </div>
        <br>
         <form class="register-form">
            <input type="text" placeholder="Full Name"/>
            <input type="text" placeholder="Last Name"/>
            <input type="password" placeholder="password"/>
            <input type="text" placeholder="email address"/>
            <input type="pwd" placeholder="confirm pw"/>
            
        </form>
        <form class="login-form">
            <input type="text" placeholder="Full Name"/>
            <input type="text" placeholder="Last Name"/>
            <input type="text" placeholder="Email"/>
            <input type="password" placeholder="Password"/>
            <input type="pwd" placeholder="Confirm Password"/>
            <select name="login-as">
                <option value="student">Login as Student</option>
                <option value="landowner">Login as Land Lord</option>
                <option value="landowner">Login as Warden</option>
                <option value="admin">Login as Admin</option>
            </select>
            <button>Sign Up</button>
            <br>
            <br>
            
        </form>
    </div>
</div>
<?php include('footer.php'); ?>
</body>
</html>

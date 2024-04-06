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
         <form class="register-form">
            <input type="text" placeholder="name"/>
            <input type="password" placeholder="password"/>
            <input type="text" placeholder="email address"/>
            <button>create</button>
            <p class="message">Already registered? <a href="#">Sign In</a></p>
        </form>
        <form class="login-form">
            <input type="text" placeholder="Email"/>
            <input type="password" placeholder="password"/>
            <select name="login-as">
        <option value="admin">Login as Admin</option>
        <option value="student">Login as Student</option>
        <option value="landowner">Login as Landowner</option>
    </select>
            <button>login</button>
            <br>
            <br>
            <p class="message"><a href="#">Forgot Password?</a></p>
            <p class="message">Not registered? <a href="#">Create an account</a></p>
            
        </form>
    </div>
</div>

</body>
</html>

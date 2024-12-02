<?php
session_start(); // Start the session to manage user session data
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php 
              require("connection.php"); // Include the configuration file for database connection
            if(isset($_POST['signin'])){
                // Retrieve and sanitize the form data
                $email = $_POST['email'];
                $password = $_POST['pass'];

                // Query the database to check if the username and password match
                $result = $db -> prepare("SELECT * FROM user WHERE Email=? AND Password=? ");
                $result ->bindParam(1,$email);
                $result ->bindParam(2,$password);
                $result ->execute();
                $row= $result->fetch() ;
                $result1 = $db -> prepare("SELECT count(*) FROM user WHERE Email=? AND Password=? ");
                $result1 ->bindParam(1,$email);
                $result1 ->bindParam(2,$password);
                $result1 ->execute();
                $row1 = $result1 ->fetchColumn();
                

                if($row1>0){
                    // If a matching record is found, store user data in session variables
                    $_SESSION['valid'] = $row['Email'];
                    $_SESSION['username'] = $row['Email'];
                    $_SESSION['userid'] = $row['id'];
                    $_SESSION['Type'] = $row['Type'];

                }else{
                    // If no matching record is found, display an error message and a button to go back
                    echo "<div class='message'>
                    <p class='fail'>Wrong Username or Password</p>
                    </div> <br>";
                  echo "<a href='signin.php'><button class='btn'>Go Back</button>";
                  
                }
                if(isset($_SESSION['valid']) && ($_SESSION['Type'] == 'User')){
                    $_SESSION['activeUser']= $row['Email'];
                    // If user data is stored in session, redirect to home.php
                    header("Location: home.php");
                }
            }
              else if(isset($_SESSION['valid']) && ($_SESSION['Type'] == 'Admin')){
                header("Location: Admin.php");
              }else{
              ?>

<div class="main">

<!-- Sing in  Form -->
<section class="sign-in">
    <div class="container">
        <div class="signin-content">
            <div class="signin-image">
                <figure><img src="images/signin-image.jpg" alt="sing up image"></figure>
                <a href="signup.php" class="signup-image-link">Create an account</a>
            </div>

            <div class="signin-form">
                <h2 class="form-title">Sign in</h2>
                <form method="POST" class="register-form" id="login-form">
                    <div class="form-group">
                        <label for="your_name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                        <input type="text" name="email" id="your_name" placeholder="Your Email"/>
                    </div>
                    <div class="form-group">
                        <label for="your_pass"><i class="zmdi zmdi-lock"></i></label>
                        <input type="password" name="pass" id="your_pass" placeholder="Password"/>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="remember-me" id="remember-me" class="agree-term" />
                        <label for="remember-me" class="label-agree-term"><span><span></span></span>Remember me</label>
                    </div>
                    <div class="form-group form-button">
                        <input type="submit" name="signin" id="signin" class="form-submit" value="Log in"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

</div>
<?php } ?>
</body>
</html>
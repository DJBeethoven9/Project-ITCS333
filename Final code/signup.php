<?php
 // Regular expressions for validation
$fullNameRegex = '/^[a-zA-Z\s]{3,15}$/'; // Regex for full name validation: allows alphabetic characters and spaces, length between 3 and 15
$emailRegex = '/^[0-9]{8}@stu\.uob\.edu\.bh$/'; // Regex for email validation: follows standard email format
$passwordRegex = "/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])[A-Za-z0-9_#@%*\\-]{8,24}$/"; // Regex for password validation: allows at least one lowercase letter, one uppercase letter, one digit, and one special character, length between 8 and 25
require("connection.php");

$msg = ""; // Variable to store error or success messages

if (isset($_POST['signup'])) {
    // Retrieve form data
    $fullName = $_POST['name']; 
    $email = $_POST['email'];
    $password = $_POST['pass'];
    $confirmPassword = $_POST['re-pass'];

    $valid = true; // Flag to track form field validation

    // Validate full name
    if (!preg_match($fullNameRegex, $fullName)) {
        $msg = "Please enter a valid full name (3-15 alphabetic characters and spaces)";
        $valid = false;
    }

    // Validate email
    if (!preg_match($emailRegex, $email)) {
        $msg = "Please enter a valid email address";
        $valid = false;
    }

    // Validate password
    if (!preg_match($passwordRegex, $password)) {
        $msg = "Password must be 8-25 characters long and include at least one lowercase letter, one uppercase letter, one digit, and one special character";
        $valid = false;
    }

    // Validate confirm password
    if ($password !== $confirmPassword) {
        $msg = "Confirm password does not match the password";
        $valid = false;
    }

    if ($valid) {
        // Verify unique email and username
        $verify_email_query = $db ->prepare("SELECT count(*) FROM user WHERE Email=?");
        $verify_email_query ->bindParam(1,$email);
        $verify_email_query ->execute();
        $count = $verify_email_query -> fetchColumn();
        if ($count != 0) {
            $msg = "This email is already used. Please try another one.";
        } else {
            // Insert user data into the database 
        $insert = $db ->prepare("INSERT INTO user VALUES (NULL,?, ?, ?'User'");
        $insert ->bindParam(1,$fullName);
        $insert ->bindParam(2,$email);
        $insert ->bindParam(3,$password);
        $insert ->execute();

            $msg = "Registration successful!";
        }
    }
}
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
<div class="main">

<!-- Sign up form -->
<section class="signup">
    <div class="container">
        <div class="signup-content">
            <div class="signup-form">
                <h2 class="form-title">Sign up</h2>
                <form method="POST" class="register-form" id="register-form" action="booking_system.php">
                    <div class="form-group">
                        <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                        <input type="text" name="name" id="name" placeholder="Your Name"/>
                    </div>
                    <div class="form-group">
                        <label for="email"><i class="zmdi zmdi-email"></i></label>
                        <input type="email" name="email" id="email" placeholder="Your Email"/>
                    </div>
                    <div class="form-group">
                        <label for="pass"><i class="zmdi zmdi-lock"></i></label>
                        <input type="password" name="pass" id="pass" placeholder="Password"/>
                    </div>
                    <div class="form-group">
                        <label for="re-pass"><i class="zmdi zmdi-lock-outline"></i></label>
                        <input type="password" name="re_pass" id="re_pass" placeholder="Repeat your password"/>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="agree-term" id="agree-term" class="agree-term" />
                        <label for="agree-term" class="label-agree-term"><span><span></span></span>I agree all statements in  <a href="#" class="term-service">Terms of service</a></label>
                    </div>
                    <div class="form-group form-button">
                        <input type="submit" name="signup" id="signup" class="form-submit" value="Register"/>
                    </div>
                </form>
            </div>
            <div class="signup-image">
                <figure><img src="images/signup-image.jpg" alt="sing up image"></figure>
                <a href="signin.php" class="signup-image-link">I am already member</a>
            </div>
        </div>
    </div>
</section>

<div class="main">
</body>
</html>
<?php 
session_start();
require("connection.php");

if (!isset($_SESSION['valid'])) {
    header("Location: index.php");
}

$emailRegex = '/^[0-9]{3,12}@stu\.uob\.edu\.bh$/';
$passwordRegex = "/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])[A-Za-z0-9_#@%*\\-]{8,24}$/";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X--Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="profile.css">
    <title>Change Profile</title>
</head>
<body>
    <div class="nav">
        <div class="logo">
            <p><a href="homepage.php"> UOB</a></p>
        </div>
        <div class="right-links">
            <a href="profile.php">Change Profile</a>
            <a href="logout.php">
                <button class="btn">Log Out</button>
            </a>
        </div>
    </div>

    <div class="container">
        <div class="box form-box">
            <?php
            if (isset($_POST['submit'])) {
                $email = $_POST['email'];
                $password = $_POST['password'];
                $confirm_password = $_POST['confirm_password'];
                $profile_pic = $_FILES['profile_pic'];
                $id = $_SESSION['userid'];
                $check = $db->prepare("SELECT * FROM user WHERE id=?");
                $check->bindParam(1,$id);
                $check->execute();
                while($r= $check->fetch()){
                    if(empty($email)){
                        $email = $r['Email'];
                    }
                    $currentEmail = $r['Email'];
                    
                    if(empty($password))
                    {
                        $password= $r["Password"];
                        $confirm_password = $password;

                    }

                    
                    if ($_FILES["profile_pic"]["error"] === UPLOAD_ERR_NO_FILE) {
                        $profile_pic_folder = $r['pfp']; }
                    
                    
                }  
                
                
                if (!preg_match($emailRegex, $email)) {
                    echo "<div class='message'>
                        <p>Please enter a valid email address .</p>
                    </div> <br>";echo "<a href='profile.php'><button class='btn'>Go Back</button>";
                } elseif (!preg_match($passwordRegex, $password)) {
                    echo "<div class='message'>
                        <p>Please enter a valid password (8-25 characters, at least one uppercase letter, one lowercase letter, and one special character).</p>
                    </div> <br>";echo "<a href='profile.php'><button class='btn'>Go Back</button>";
                } elseif ($password !== $confirm_password) {
                    echo "<div class='message'>
                        <p>Passwords do not match.</p>
                    </div> <br>";echo "<a href='profile.php'><button class='btn'>Go Back</button>";
                    
                } else {
                    if(!empty($_POST['email'])){
                    $check = $db->prepare("SELECT * FROM user where Email =?");
                    $check->bindParam(1,$email);
                    $check->execute();
                    if($check->rowCount() > 0){
                        echo "<div class='message'>
                        <p>The Email: $email is already used so it won't be updated other than the email.</p>
                    </div> <br>";
                    $email = $currentEmail;
                    }
                    
                }

                if(!$_FILES["profile_pic"]["error"] > 0){
                    $profile_pic_name = $profile_pic['name'];
                    $profile_pic_tmp_name = $profile_pic['tmp_name'];
                    $profile_pic_folder = 'images/' . $profile_pic_name;
                    
                    move_uploaded_file($profile_pic_tmp_name, $profile_pic_folder);
                }


                    $edit_query = $db->prepare("UPDATE user SET Email=?, Password=?, pfp=? WHERE id=?");
                    $edit_query->bindParam(1, $email);
                    $edit_query->bindParam(2, $password);
                    $edit_query->bindParam(3, $profile_pic_folder);
                    $edit_query->bindParam(4, $id);
                    $edit_query->execute();

                    if ($edit_query) {
                        echo "<div class='message'>
                        <p>Profile Updated! </p>
                    </div> <br>";
                        echo "<a href='profile.php'><button class='btn'>Go Home</button>";
                    }
                }
            }
        
            else {
                $id = $_SESSION['userid'];
                $query = $db->prepare("SELECT Email, pfp FROM user WHERE id=?");
                $query->bindParam(1, $id);
                $query->execute();

                while ($result = $query->fetch()) {
                    $res_Email = $result['Email'];
                    $res_Profile_Pic = $result['pfp'];
                }
            ?>
            <header class="page-title">Change Profile</header>
            <div class="profile-picture"> <img src="<?php echo $res_Profile_Pic; ?>" alt="Profile Picture"> </div>
            
            <form action="" method="post" enctype="multipart/form-data">
                
            <div class="field input profile-picture-update"> 

                <label for="profile_pic">Update Profile Picture</label> 

            <input type="file" name="profile_pic" id="profile_pic"> 
        </div>


                <div class="field input">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" placeholder="your current email: <?php echo $res_Email; ?>" autocomplete="off" >
                </div>

                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" autocomplete="off" >
                </div>

                <div class="field input">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" name="confirm_password" id="confirm_password" autocomplete="off" >
                </div>

                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Update" required>
                </div>
            </form>
        </div>
        <?php } ?>
    </div>
</body>
</html>

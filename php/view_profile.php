<?php
session_start();
require 'connection.php';

if (!isset($_SESSION['userid'])) {
    header("Location: signin.php");
    exit();
}

$id = $_SESSION['userid'];
$query = $db->prepare("SELECT Email, pfp FROM user WHERE id=?");
$query->bindParam(1, $id);
$query->execute();
$user = $query->fetch();

if (!$user) {
    echo "<div class='message'>
        <p>User not found.</p>
    </div> <br>";
    echo "<a href='profile.php'><button class='btn'>Go Back</button>";
    exit();
}

$email = $user['Email'];
$profile_pic = $user['pfp'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Profile</title>
    <link rel="stylesheet" href="..\Css\profile.css">
</head>
<body>
<?php include("nav.php"); ?> 
    <div class="container">
        <header class="page-title">Profile</header>
        <div class="profile-picture">
            <img src="<?php echo $profile_pic; ?>" alt="Profile Picture">
        </div>
        <div class="profile-details">
            <p><strong>Email:</strong> <?php echo $email; ?></p>
        </div>
        <a href="profile.php"><button class="btn">Edit Profile</button></a>
        <a href="logout.php"><button class="btn">Log Out</button></a>
    </div>
</body>
</html>
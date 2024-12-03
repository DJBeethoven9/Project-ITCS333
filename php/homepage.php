<?php 
session_start();
require 'connection.php';

if (!isset($_SESSION['activeUser'])) {
    header("Location: signin.php");
    exit();
}

$search = '';
if (isset($_POST['search'])) {
    $search = $_POST['search'];
}

$query = $db->prepare("SELECT * FROM rooms WHERE room_name LIKE ?");
$query->execute(['%' . $search . '%']);
$rooms = $query->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="..\Css\style.css">
</head>
<body>
    <div class="container">
        <header class="page-title">Dashboard</header>
        <form method="post" action="homepage.php">
            <input type="text" name="search" placeholder="Search rooms..." value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit">Search</button>
        </form>
        <div class="dropdown">
            <button class="dropbtn">Menu</button>
            <div class="dropdown-content">
                <a href="view_profile.php">View Profile</a>
                <a href="edit_profile.php">Edit Profile</a>
                <a href="logout.php">Log Out</a>
            </div>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Room Name</th>
                    <th>Capacity</th>
                    <th>Price</th>
                    <th>Availability</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rooms as $room): ?>
                <tr>
                    <td><?php echo htmlspecialchars($room['room_name']); ?></td>
                    <td><?php echo htmlspecialchars($room['capacity']); ?></td>
                    <td><?php echo htmlspecialchars($room['price']); ?></td>
                    <td><?php echo htmlspecialchars($room['availability']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
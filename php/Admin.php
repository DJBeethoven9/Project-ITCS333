<?php 
session_start();
require("connection.php");

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

if (isset($_POST['add_room'])) {
    $room_name = $_POST['room_name'];
    $capacity = $_POST['capacity'];
    $price = $_POST['price'];
    $availability = $_POST['availability'];

    $add_query = $db->prepare("INSERT INTO rooms (room_name, capacity, price, availability) VALUES (?, ?, ?, ?)");
    $add_query->bindParam(1, $room_name);
    $add_query->bindParam(2, $capacity);
    $add_query->bindParam(3, $price);
    $add_query->bindParam(4, $availability);
    $add_query->execute();

    if ($add_query) {
        echo "<div class='message'>
            <p>Room added successfully!</p>
        </div> <br>";
    }
}

if (isset($_POST['remove_room'])) {
    $room_id = $_POST['room_id'];

    $remove_query = $db->prepare("DELETE FROM rooms WHERE id=?");
    $remove_query->bindParam(1, $room_id);
    $remove_query->execute();

    if ($remove_query) {
        echo "<div class='message'>
            <p>Room removed successfully!</p>
        </div> <br>";
    }
}

$rooms_query = $db->prepare("SELECT * FROM rooms");
$rooms_query->execute();
$rooms = $rooms_query->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Css/admin.css">
    <title>Admin Dashboard</title>
</head>
<body>
    <?php include("nav.php"); ?>

    <div class="container">
        <div class="box form-box">
            <h2>Admin Dashboard</h2>
            <h3>Add Room</h3>
            <form method="post" action="admin.php">
                <div class="field input">
                    <label for="room_name">Room Name</label>
                    <input type="text" name="room_name" id="room_name" required>
                </div>
                <div class="field input">
                    <label for="capacity">Capacity</label>
                    <input type="number" name="capacity" id="capacity" required>
                </div>
                <div class="field input">
                    <label for="price">Price</label>
                    <input type="number" name="price" id="price" required>
                </div>
                <div class="field input">
                    <label for="availability">Availability</label>
                    <input type="text" name="availability" id="availability" required>
                </div>
                <button type="submit" name="add_room" class="btn">Add Room</button>
            </form>

            <h3>Remove Room</h3>
            <form method="post" action="admin.php">
                <div class="field input">
                    <label for="room_id">Room ID</label>
                    <input type="number" name="room_id" id="room_id" required>
                </div>
                <button type="submit" name="remove_room" class="btn">Remove Room</button>
            </form>

            <h3>Available Rooms</h3>
            <table>
                <thead>
                    <tr>
                        <th>Room ID</th>
                        <th>Room Name</th>
                        <th>Capacity</th>
                        <th>Price</th>
                        <th>Availability</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rooms as $room): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($room['id']); ?></td>
                        <td><?php echo htmlspecialchars($room['room_name']); ?></td>
                        <td><?php echo htmlspecialchars($room['capacity']); ?></td>
                        <td><?php echo htmlspecialchars($room['price']); ?></td>
                        <td><?php echo htmlspecialchars($room['availability']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
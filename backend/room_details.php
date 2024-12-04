<?php
// Hardcoded room data
$rooms = [
    1 => ["name" => "Room 101", "capacity" => "20", "equipment" => "Projector, Whiteboard", "timeslots" => ["9:00 AM - 10:00 AM", "10:00 AM - 11:00 AM"]],
    2 => ["name" => "Room 102", "capacity" => "15", "equipment" => "TV, Whiteboard", "timeslots" => ["9:00 AM - 10:00 AM", "1:00 PM - 2:00 PM"]],
    3 => ["name" => "Room 103", "capacity" => "25", "equipment" => "Projector, TV", "timeslots" => ["11:00 AM - 12:00 PM", "2:00 PM - 3:00 PM"]],
];

// Get the room ID from the URL
$room_id = isset($_GET['id']) ? (int)$_GET['id'] : 1;

// Get the room details
$room = $rooms[$room_id];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Details</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Room Details</h1>
    <div class="room-details">
        <h2><?php echo $room['name']; ?></h2>
        <p>Capacity: <?php echo $room['capacity']; ?> people</p>
        <p>Equipment: <?php echo $room['equipment']; ?></p>
        <h3>Available Timeslots:</h3>
        <ul>
            <?php foreach ($room['timeslots'] as $timeslot): ?>
                <li><?php echo $timeslot; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <a href="homepage.php">Back to Room List</a>
</body>
</html>

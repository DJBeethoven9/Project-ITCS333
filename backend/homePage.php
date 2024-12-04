<?php
// Hardcoded room data
$rooms = [
    ["id" => 1, "name" => "Room 101", "capacity" => "20", "equipment" => "Projector, Whiteboard", "timeslots" => ["9:00 AM - 10:00 AM", "10:00 AM - 11:00 AM"]],
    ["id" => 2, "name" => "Room 102", "capacity" => "15", "equipment" => "TV, Whiteboard", "timeslots" => ["9:00 AM - 10:00 AM", "1:00 PM - 2:00 PM"]],
    ["id" => 3, "name" => "Room 103", "capacity" => "25", "equipment" => "Projector, TV", "timeslots" => ["11:00 AM - 12:00 PM", "2:00 PM - 3:00 PM"]],
];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Browsing</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Room Browsing</h1>
    <div class="rooms">
        <?php foreach ($rooms as $room): ?>
            <div class="room">
                <h2><?php echo $room['name']; ?></h2>
                <p>Capacity: <?php echo $room['capacity']; ?> people</p>
                <p>Equipment: <?php echo $room['equipment']; ?></p>
                <a href="room_details.php?id=<?php echo $room['id']; ?>">View Details</a>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>

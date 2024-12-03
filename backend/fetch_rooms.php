<?php
// Simulate data fetching from a database (you can later replace this with actual DB queries)
$rooms = [
    ['id' => 1, 'name' => 'Room A', 'capacity' => 20, 'equipment' => 'Projector'],
    ['id' => 2, 'name' => 'Room B', 'capacity' => 15, 'equipment' => 'Whiteboard'],
    ['id' => 3, 'name' => 'Room C', 'capacity' => 10, 'equipment' => 'Conference Phone'],
    // You can add more rooms here if needed...
];

// Set the response type to JSON
header('Content-Type: application/json');

// Output the room data as JSON
echo json_encode($rooms);
?>


//have a nice day
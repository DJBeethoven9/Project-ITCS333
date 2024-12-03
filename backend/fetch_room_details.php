<?php
// Get the room ID from the query parameter (e.g., ?id=1)
$room_id = isset($_GET['id']) ? $_GET['id'] : null;

if ($room_id) {
    // Simulate data fetching from a database (you can replace this with actual DB queries)
    $room_details = [
        1 => ['name' => 'Room A', 'capacity' => 20, 'equipment' => 'Projector', 'available_times' => ['9:00 AM', '1:00 PM']],
        2 => ['name' => 'Room B', 'capacity' => 15, 'equipment' => 'Whiteboard', 'available_times' => ['10:00 AM', '2:00 PM']],
        3 => ['name' => 'Room C', 'capacity' => 10, 'equipment' => 'Conference Phone', 'available_times' => ['11:00 AM', '3:00 PM']],
        // Add more rooms here if needed...
    ];

    // If the room ID exists, return its details
    if (isset($room_details[$room_id])) {
        header('Content-Type: application/json');
        echo json_encode($room_details[$room_id]);
    } else {
        // If room ID is not found, return an error message
        echo json_encode(['error' => 'Room not found']);
    }
} else {
    echo json_encode(['error' => 'Room ID is required']);
}
?>

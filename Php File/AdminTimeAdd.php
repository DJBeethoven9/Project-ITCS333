<?php 
require("conn.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['start-time']) && isset($_POST['end-time']) && isset($_POST['room-id'])) {
    $startTime = $_POST['start-time'];
    $endTime = $_POST['end-time'];
    $roomId = $_POST['room-id'];

   
    $conflictCheckSql = "SELECT * FROM timeslot WHERE room_id = ? AND NOT (end_duration <= ? OR start_duration >= ?)";
    
    $conflictCheckStmt = $db->prepare($conflictCheckSql);
    $conflictCheckStmt->bindParam(1, $roomId);
    $conflictCheckStmt->bindParam(2, $startTime);
    $conflictCheckStmt->bindParam(3, $endTime);
    $conflictCheckStmt->execute();

    if ($conflictCheckStmt->rowCount() > 0) {
      
        header("Location: AdminTimeManage.php?msg=Time slot conflicts with an existing timeslot with the room_id $roomId.");
        exit();
    } else {
        
        $MAli = $db->prepare("INSERT INTO timeslot  VALUES (NULL,?, ?, ?)");
        $MAli->bindParam(1, $roomId);
        $MAli->bindParam(2, $startTime);
        $MAli->bindParam(3, $endTime);
        
        $MAli->execute();

        if ($MAli) {
            header("Location: AdminTimeManage.php?msg=The TimeSlot has been successfully added.");
        } else {
            header("Location: AdminTimeManage.php?msg=Failed to add the TimeSlot.");
        }
    }
}else{
    echo "Error";
}
?>

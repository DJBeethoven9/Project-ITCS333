<?php
try {
    require('connection.php');
    
    session_start();
    if (isset($_SESSION)) {
        session_destroy();
    }
    header("Location: homepage.php");
    exit;
} catch(PDOException $e) {
    die($e->getMessage());
}
?>
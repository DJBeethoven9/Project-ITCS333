<?php 
session_start();

if(isset( $_SESSION['activeUser'])){
    echo "<h1>Hello world</h1>";
}
else
echo "<h1>im not user</h1>";







?>
<a href="logout.php">logout</a>
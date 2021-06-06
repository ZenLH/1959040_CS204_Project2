<?php
    session_start();
    include 'db.php';
    if(!isset($_SESSION['loggedin'])){
        $_SESSION['loggedin'] = false;
    }
?>
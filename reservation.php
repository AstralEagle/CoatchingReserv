<?php 
    session_start();
    if (isset($_GET['id']) || !empty($_GET['id'])) {
        include("header.php");
        include("reserv.php");
    }
?>
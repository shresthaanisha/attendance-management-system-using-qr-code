<?php 
    session_start();

    if(isset($_SESSION['authenticated']))
    {
        $_SESSION['status'];
        header('location: student.php');
        exit(0);
    }



?>
<?php

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve username and password from the form
    $username = $_POST['username'];
    $password = $_POST['pass'];

    // Check if both username and password are "admin"
    $storedHashedPassword = password_hash('admin', PASSWORD_DEFAULT);

    // Check if both username and password are valid
    if ($username === 'admin' && password_verify($password, $storedHashedPassword)) {
        // Successful login, redirect to a dashboard or another page
        session_start();
        $_SESSION['username'] = $username;
        header('Location: final.php');
        exit();
    } else {
        // Invalid login, display an error message
        // echo 'Invalid username or password';
        header('Location: index.php?error=true');
        exit();
    }
}
?>
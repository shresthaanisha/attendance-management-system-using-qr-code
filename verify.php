<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include('connect.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

function sendmail_verify($username, $email, $verification_code)
{
    $mail = new PHPMailer(true);
    // $mail->SMTPDebug = 2; // Enable verbose debug output
    $mail->isSMTP();
    $mail->SMTPAuth = true;

    $mail->Host = "smtp.gmail.com";
    $mail->Username = "projecttest4404@gmail.com";
    $mail->Password = "lxhl togw lfbf phvq";    

    $mail->SMTPSecure = "tls";
    $mail->Port = 587;

    $mail->setFrom("projecttest4404@gmail.com");
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = "Email Verification from AttMgmt Project";

    $email_template = "
    <h2>You have Registered with AttMgmt Project</h2>
    <h5>Please verify your email address to log in through the given link:</h5>
    <br/><br/>
    <a href='http://localhost/4th%20project/Login/verify-email.php?token=" . urlencode($verification_code) . "'> Verify </a>

";
    

    $mail->Body = $email_template;
    $mail->send();
    // echo"Message has been sent";
}

if(isset($_POST['register_btn']))
{
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $verification_code = md5(rand()); // Generate a verification code

 // Check if email exists in the "students" table
 $check_students_query = "SELECT email FROM students WHERE email='$email' LIMIT 1";
 $check_students_query_run = mysqli_query($conn, $check_students_query);

 // Check if email exists in the "users" table
 $check_users_query = "SELECT email FROM users WHERE email='$email' LIMIT 1";
 $check_users_query_run = mysqli_query($conn, $check_users_query);

 if (mysqli_num_rows($check_students_query_run) > 0 && mysqli_num_rows($check_users_query_run) == 0) {
     // Email exists in "students" table but not in "users" table, proceed with registration
     // Insert user data into the database
     $query = "INSERT INTO users (username, password, email, verification_code) VALUES ('$username', '$password','$email', '$verification_code')";
     $query_run = mysqli_query($conn, $query);

        if($query_run)
        {
            // Send verification email
            sendmail_verify($username, $email, $verification_code);  
            $_SESSION['status'] = "Registration Successful. Please verify your Email Address";
            header("Location: register.php");
        }
        else
        {
            $_SESSION['status'] = "Registration failed";
            header("Location: register.php");
        }
    }
    else
    {
            // Email does not exist in "students" table or exists in "users" table, show an error
            $_SESSION['status'] = "Email not registered by admin Or the email already exists. ";
            header("Location: register.php");
    }
}
?>

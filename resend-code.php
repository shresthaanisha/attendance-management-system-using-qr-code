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
    

    function resend_email_verify($username, $email, $verification_code)
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
        $mail->Subject = "Resend - Email Verification from AttMgmt Project";
    
        $email_template = "
            <h2> You have Registered with AttMgmt Project<h2>
            <h5> Please verify your email address to Login through given link<h5>
            <br/><br/>
            <a href='http://localhost/4th%20project/Login/verify-email.php?token=$verification_code'> Verify </a>
        ";
    
        $mail->Body = $email_template;
        $mail->send();
    }
    if(isset($_POST['btnsubmit']))
    {
        if(!empty(trim($_POST['email'])))
        {
            $email = mysqli_real_escape_string($conn, $_POST['email']);

            $checkemail_query = "SELECT * FROM users WHERE email= '$email' LIMIT 1";
            $checkemail_query_run = mysqli_query($conn, $checkemail_query);

            if(mysqli_num_rows($checkemail_query_run) > 0)
            {
                $row = mysqli_fetch_array($checkemail_query_run);
                if($row['verify_status'] == 0)
                {
                    $username = $row['username'];
                    $email = $row['email'];
                    $verification_code = $row['verification_code'];
                    resend_email_verify($username, $email, $verification_code);
                    header('location: login.php?verification=true');
                    exit(0);
                }
                else
                {
                    header('location: login.php?login=true');
                    exit(0);
                }
            }   
            else
            {
                $_SESSION['status'] = "Email not Registered. Please register now";
                header('location: register.php');
                exit(0);
            }
        }
        else
        {
            header("location:resend-email-verification.php?fail = true");
            exit(0);
        }

    }
?>
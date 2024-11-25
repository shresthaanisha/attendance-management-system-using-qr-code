<?php
session_start();
include('connect.php');

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Debugging output to check the received token
    // echo "Received Token: " . $token . "<br>";

    $verify_query = "SELECT verification_code, verify_status FROM users WHERE verification_code = '$token' LIMIT 1";
    $verify_query_run = mysqli_query($conn, $verify_query);

    if ($verify_query_run) {
        if (mysqli_num_rows($verify_query_run) > 0) {
            $row = mysqli_fetch_array($verify_query_run);
            
            // Debugging output to check the database token
            echo "Database Token: " . $row['verification_code'] . "<br>";

            if ($row['verify_status'] == "0") {
                $clicked_token = $row['verification_code'];
                $update_query = "UPDATE users SET verify_status = '1' WHERE verification_code = '$clicked_token' LIMIT 1";
                $update_query_run = mysqli_query($conn, $update_query);

                // Debugging output to check the update query
                echo "Update Query: $update_query<br>";

                if ($update_query_run) {
                    $_SESSION['status'] = "Your Account has been verified Successfully!";
                    header("location: login.php");
                    exit(0);
                } else {
                    $_SESSION['status'] = "Verification Failed!";
                    header("location: login.php");
                    exit(0);
                }
            } else {
                $_SESSION['status'] = "Email already verified. Please Login";
                header("location: login.php?register=true");
                exit(0);
            }
        } else {
            $_SESSION['status'] = "This token does not exist";
            // header("location: register.php");
        }
    } else {
        // Debugging output to check for SQL errors
        echo "MySQL Error: " . mysqli_error($conn) . "<br>";
    }
} else {
    $_SESSION['status'] = "Not Allowed";
    header("location: login.php");
}
?>

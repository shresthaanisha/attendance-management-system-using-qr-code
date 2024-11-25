<?php 
    include('connect.php');
    session_start();

    if(isset($_POST['login_btn']))
    {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);


        
        $login_query = "SELECT * from users WHERE email = '$email' AND password= '$password' LIMIT 1    ";
        $login_query_run = mysqli_query($conn, $login_query);

        if(mysqli_num_rows($login_query_run) > 0)
        {
            $row = mysqli_fetch_array($login_query_run);
            
            if($row['verify_status'] == "1")
            {
                $_SESSION['authenticated'] = TRUE;
                $_SESSION['auth_user'] = [
                    'username'  => $row['username'],
                    'email'  => $row['email'],
                ];
                // $_SESSION['status'] = "You are logged in successfully.";
                header("location: student.php");
                exit(0);
            }
            else{
                header('location: login.php?error=true');
                exit(0);
    
            }
        }
        else{
            header('location: login.php?fail=true');
            exit(0);

        }

    }
?>
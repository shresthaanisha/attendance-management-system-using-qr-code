<?php
session_start();
include('connect.php');

?>

<!DOCTYPE html>
<html>

<head>
    <title>User Registration</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="css\registercss.css">

    <style>
        .password-input-container {
        position: relative;
    }   

    #eye-icon {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #555; 
        transition: color 0.3s ease;
    }
  
    #eye-icon:hover {
        color: #809bce; 
    }
    </style>

    <script>
    function togglePasswordVisibility() {
        var passwordInput = document.getElementById('password');
        var eyeIcon = document.getElementById('eye-icon');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        }
    }
</script>
    
</head>

<body>
    <div class="container">
    <?php 
                        if(isset($_SESSION['status'])){
                            echo("<h4>".$_SESSION['status']."</h4>");
                            unset($_SESSION['status']);
                        }
                        ?>
        <div class="title">Register Your Account</div>
        <div>
            <form method="post" action="verify.php">
                <div class="user-information">
                    <div class="box-card">
                        <label class="col-lg-3 col-form-label form-control-label" for="username">Username:</label>
                        <input type="text" name="username" required placeholder="username">
                    </div>

                    <div class="box-card">
                        <label class="col-lg-3 col-form-label form-control-label" for="email">Email:</label>
                        <input type="email" name="email" required placeholder="email">
                    </div>

                    <div class="box-card">
                        <label class="col-lg-3 col-form-label form-control-label" for="password">Password:</label>
                        <div class="password-input-container">
                        <input type="password" id ="password" name="password" required placeholder="password">
                        <i id="eye-icon" class="fas fa-eye eye-icon" onclick="togglePasswordVisibility('password')"></i>
                    </div>
                    </div>

                    <div class="button">
                    <input type="submit" name="register_btn" value="Register">
                    </div>

                    <?php 
                        if(isset($_GET['success']))
                        {
                             echo '<p style="color: green;"> Registration successful! Check your email for verification. </p>';
                           
                        }	
                        if(isset($_GET['error']))
                        {
                            echo '<p style="color: red;"> Email is not registered by admin. Email given by admin can only be registered. </p>';
                        }
                        if(isset($_GET['duplicate']))
                        {
                            echo '<p style="color: red;"> Username already registered</p>';
                        }
                    ?>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
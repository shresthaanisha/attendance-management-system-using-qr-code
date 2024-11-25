<!DOCTYPE html>
<html lang="en">
<head>
	<title>Student Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/mainc.css">
<!--===============================================================================================-->

</head>
<body>
	
	<?php
		include('connect.php');	
		session_start();
	?>
	<div class="limiter">
		<div class="container-login100">



			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
				
						<img src="images/1.png" alt="IMG">
				

				</div>

				<form action="logincode.php" method="post" class="login100-form validate-form">
					<span class="login100-form-title">
						Student Login
						<?php 
				if(isset($_SESSION['status']))
				{
					?>
					<div class="alert alert-success">
						<h5><?=$_SESSION['status']; ?></h5>
					</div>
					<?php
					unset($_SESSION['status']);
				}
			?>
					</span>
<!-- 
					<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
						<input class="input100" type="text" name="email" placeholder="Email">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div> -->
					<div class="wrap-input100 validate-input" data-validate = "Email is required">
						<input class="input100" type="email" id="email" name="email" placeholder="Email">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						<input class="input100" type="password" id="password" name="password" placeholder="Password" >
						
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
						<i id="eye-icon" class="fa fa-eye" aria-hidden="true" onclick="togglePasswordVisibility()"></i>
						
						<!-- <span class="symbol-imput100"><i class="bi bi-eye"></i></span> -->
					</div>
					
					
					<div class="container-login100-form-btn">
						<button type= "submit" name="login_btn" class="login100-form-btn">
							Login
						</button>

						<a href="register.php" name="register">Don't have an accout? Register here</a>
						<p>
							Did not receive verification email?
							<a href="resend-email-verification.php">Resend</a>
						</p>
						<?php
							if(isset($_GET['success']))
							{
								echo '<p style="color: green;"> Your Account has been verified Successfully! </p>';
							}	
							if(isset($_GET['register']))
							{
								echo '<p style="color: red;"> Account already registered!! </p>';
							}
   						 // Display error message if set
    					if (isset($_GET['error']))
						 {
        					echo '<p style="color: red;">Email not verified. Please verify your mail and try again</p>';
   						 }
							if(isset($_GET['fail']))
							{
								echo '<p style="color: red;"> Invalid email or password!! </p>';
							}	
							if(isset($_GET['login']))
							{
								echo '<p style="color: green;"> Email already verified. Please login to Access student portal.!! </p>';
							}		
							if(isset($_GET['verification']))
							{
								echo '<p style="color: green;"> Link sent to your email. </p>';
							}	
								
						?>


					</div>

					<!-- <div class="text-center p-t-12">
						<span class="txt1">
							Forgot
						</span>
						<a class="txt2" href="#">
							Username / Password?
						</a>
					</div>

					<div class="text-center p-t-136">
						<a class="txt2" href="#">
							Create your Account
							<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
						</a>
					</div> -->
				</form>
			</div>
		</div>
	</div>
	


	
<!--===============================================================================================-->	
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/tilt/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})

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
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>
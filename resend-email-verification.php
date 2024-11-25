<?php
    session_start();
    $page_title = "Email verification";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css\emailver.css">
</head>
<body>
<div class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Resend Email Verification</h4>
                        </div>
                        <div class="card-body">
                           <form action="resend-code.php" method="POST">
                            <div class="user-information">
                                <label for="email"> Email Address</label>
                                <input type="email" name="email" class="form-control" placeholder="Enter Email Address"> 
                            </div>
                            <div class="button">
                                <input type="submit" name="btnsubmit" value="SUBMIT">
                            </div>
                           </form>
                           <?php 
                            if(isset($_GET['fail']))
                            {
                                echo '<p style="color: red;"> Failed to send email </p>';
                            }
                           ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
 

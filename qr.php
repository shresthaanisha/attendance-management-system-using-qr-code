<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Scanner</title>

    <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css\qrcs.css">
</head>

<body>

    <div class="container">
    <nav>
    <div class="navbar" style="margin-top: 30px;">
    <b>PLACE YOUR QR CODE ON THE CAMERA FOR SCANNING</b>
    </div>
</nav>
        <div class="row">
            <div class="col-md-6">
                <video id="preview" width="100%"></video>
                <?php
                // if (isset($_SESSION['error'])) {
                //     unset($_SESSION['error']);
                //     echo "
                //             <div class='alert alert-danger'>
                //                 <h4>Error!</h4>
                //                 " . $_SESSION['error'] . "
                //             </div>
                //         ";
                // }
                // if (isset($_SESSION['success'])) {
                //     echo "
                //             <div class='alert alert-success'>
                //                 <h4>Success!</h4>
                //                 " . $_SESSION['success'] . "
                //             </div>
                //         ";
                // }
                ?>
            </div>
            <div class="col-md-6">
            <form action="insert.php" method="post" class="form-horizontal">
                    <label for="">Scanned Details</label>
                    <input type="text" name="text" id="text" readonly="" placeholder="scan qrcode" class="form-control">
                </form>
                <table class="table table-bordered">
                    <thead class="tbody">
                        <tr>
                            <td>ID</td>
                            <td>Name</td>
                            <td>TIME IN</td>
                        </tr>
                    </thead>
                    <tbody class="tbody">
                        <?php

                        include "connect.php";

                        $sql = "SELECT id,sname,time_in FROM attendance WHERE DATE(time_in )=CURDATE() ORDER BY time_in ASC";
                        $query = $conn->query($sql);
                        while ($row = $query->fetch_assoc()) {


                            ?>
                            <tr>
                                <td>
                                    <?php echo $row['id']; ?>
                                </td>
                                <td>
                                    <?php echo $row['sname']; ?>
                                </td>
                                <td>
                                    <?php echo $row['time_in']; ?>
                                </td>

                            </tr>
                            <?php
                        }


                        ?>


                    </tbody>
                </table>


                <?php

                if (isset($_GET['success'])) {
                echo '<p style="color: green;">Recorded successfully</p>';
                }
                if (isset($_GET['error'])) {
                    echo '<p style="color: red;">Already recorded </p>';
                }
                if (isset($_GET['na'])) {
                    echo '<p style="color: red;">Invalid QR</p>';
                }
                ?>
            </div>
            </div>
        </div>
        <script>

        let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
        Instascan.Camera.getCameras().then(function (cameras) {
            if (cameras.length > 0) {
                scanner.start(cameras[0]);
            } else {
                alert("No camera found");
            }
        }).catch(function (e) {
            console.error(e);
            alert(e);
        });

        scanner.addListener('scan', function (c) {
            scannedValue = c; // Store the scanned value in the variable
            document.getElementById('text').value = scannedValue; // Set the input's value to the scanned value
            document.forms[0].submit();
        });

        // This code ensures that the input's value remains set to the scanned value even if the user interacts with the input field
        document.getElementById('text').addEventListener('input', function () {
            this.value = scannedValue; // Set the input's value to the stored scanned value
        });
    </script>

    </div>
</body>

</html>
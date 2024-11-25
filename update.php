<?php
session_start();
include "connect.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
  }

if (isset($_POST['update'])) {

    $id = $_POST['id'];

    $full_name = $_POST['full_name'];

    $course = $_POST['course'];

    $sem = $_POST['semester'];

    $phone = $_POST["phone"];

    $address = $_POST["student_address"];

    $age = $_POST['age'];

    $sql = "UPDATE students SET full_name='$full_name',course='$course',semester='$sem',phone='$phone',student_address='$address',age='$age' WHERE id='$id'";

    $result = $conn->query($sql);

    if ($result == TRUE) {

        // echo "Record updated successfully.";
        header('location: view.php?up=true');
        exit(0);

    } else {

        echo "Error:" . $sql . "<br>" . $conn->error;

    }

}

if (isset($_GET['id'])) {

    $id = $_GET['id'];

    $sql = "SELECT * FROM students WHERE id='$id'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {

            $full_name = $row['full_name'];

            $course = $row['course'];

            $sem = $row['semester'];

            $phone = $row["phone"];

            $address = $row["student_address"];

            $age = $row['age'];

            $id = $row['id'];

            // $qrcode = $row['qrcode'];

        }

        ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Update card</title>
            <link rel="stylesheet" href="css/update.css">

            <script>
  function goBack() {
    console.log("Button clicked");
    window.location.href = "view.php";
}
                    </script>
        </head>

        <body>


            <div class="container">
                <form action="" method="post">
                <div class="title">Update Student Information</div>

                    <fieldset>
                        <legend>Personal Information</legend>

                        <div class="user-information">
                            <div class="box-card">
                                <label class="col-lg-3 col-form-label form-control-label">Full Name</label>
                                <div class="col-lg-9">
                                    <input type="text" name="full_name" value="<?php echo $full_name; ?>">
                                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                                </div>
                            </div>

                            <div class="box-card">
                                <label class="col-lg-3 col-form-label form-control-label">Course</label>
                                <div class="col-lg-9">
                                    <input type="text" name="course" value="<?php echo $course; ?>">
                                </div>
                            </div>


                            <div class="box-card">
                                <label class="col-lg-3 col-form-label form-control-label">Semester</label>
                                <div class="col-lg-3"><input type="text" name="semester" value="<?php echo $sem; ?>"></div>
                            </div>

                            <div class="box-card">
                                <label class="col-lg-3 col-form-label form-control-label">Phone</label>
                                <div class="col-lg-9">
                                    <input type="number" name="phone" value="<?php echo $phone; ?>">
                                </div>
                            </div>


                            <div class="box-card">
                                <label class="col-lg-3 col-form-label form-control-label">Age</label>
                                <div class="col-lg-9">
                                    <input type="number" name="age" value="<?php echo $age; ?>">

                                </div>
                            </div>
                            <div class="box-card">
                                <label class="col-lg-3 col-form-label form-control-label">Address</label>
                                <div class="col-lg-9">
                                    <input type="text" name="student_address" value="<?php echo $address; ?>">

                                </div>

                            </div>


                            <div class="button">
                                <input type="submit" value="Update" name="update">
                            </div>
                        </div>

                    </fieldset>

                    <div class="goto">

                </form>
            </div>
<div class="goto">
<button onclick="goBack()">Go to list of student</button>
</div>
        </body>

        </html>

        <?php

    } else {

        header('Location: view.php');

    }

}

?>
</body>

</html>
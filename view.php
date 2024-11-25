<?php
session_start();
include "connect.php";

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$sql = "SELECT * FROM students";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0-alpha3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap5.min.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="../Login/css/viewc.css">

    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this record?");
        }

        function goBack() {
            window.location.href = "final.php";
        }
    </script>

</head>

<body>

    <div class="container">

        <h2><b>STUDENTS LIST</b></h2>
        <form action="search.php" method="GET">
            <div class="input-group mb-3">
                <input type="text" name="search" value="<?php if (isset($_GET['search'])) {
                                                            echo ($_GET['search']);
                                                        } ?>" class="form-control" placeholder="Search">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>
        <div class="dash">
            <button class="dash" style="
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 8px; 
        " onclick="goBack()">Go To Dashboard</button>
        </div>


        <table class="table">

            <thead>

                <tr>

                    <th>ID</th>

                    <th>Name</th>

                    <th>Course</th>

                    <th>Contact</th>

                    <th>address</th>

                    <th>age</th>

                    <th>Action</th>

                    <th>View QR code</th>

                </tr>

            </thead>

            <tbody>

                <?php

                if ($result->num_rows > 0) {

                    while ($row = $result->fetch_assoc()) {

                        ?>

                        <tr>

                            <td>
                                <?php echo $row['id']; ?>
                            </td>

                            <td>
                                <?php echo $row['full_name']; ?>
                            </td>

                            <td>
                                <?php echo $row['course']; ?>
                            </td>

                            <td>
                                <?php echo $row['phone']; ?>
                            </td>

                            <td>
                                <?php echo $row['student_address']; ?>
                            </td>

                            <td>
                                <?php echo $row['age']; ?>
                            </td>

                            <td><a class="btn btn-info" href="update.php?id=<?php echo $row['id']; ?>">Edit</a>&nbsp;<a
                                    class="btn btn-danger" href="delete.php?id=<?php echo $row['id']; ?>"
                                    onclick="return confirmDelete();">Delete</a></td>

                            <td> <a class="btn btn-info" href="imageview.php?id=<?php echo $row['id']; ?>&name=<?php echo $row['full_name']; ?>">View</a></td>
                        </tr>

                    <?php }

                }

                ?>


            </tbody>

        </table>
        <?php
        if (isset($_GET['success'])) {
            echo '<p style="color: red;">Invalid username or password</p>';
        }
        if (isset($_GET['up'])) {
            echo '<p style="color: green;">Updated successfully</p>';
        }
        if (isset($_GET['error'])) {
            echo '<p style="color: red;">Unable to update</p>';
        }
        ?>
    </div>

    <!-- DataTable JS -->
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap5.min.js"></script> -->

    <script>
        $("#example").DataTable({
            responsive: true,
        });
    </script>
</body>

</html>

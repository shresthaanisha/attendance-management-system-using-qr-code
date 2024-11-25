<?php
session_start();
include('connect.php'); 
  if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
  }

?>
<!DOCTYPE html>

<html>

<head>

    <title>View Page</title>

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

        <h2>Students</h2>
        <form action="search.php" method="GET" >


        <div class="input-group mb-3">
            <input type="text" name="search" id="search" value="<?php if(isset($_GET['search'])) {echo($_GET['search']);} ?>" class="form-control" placeholder="Search">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
        </form>

        <script>
									function goBack() {
    									window.location.href = "final.php";
									}
								</script>
								<button onclick="goBack()">Go To Dashboard</button>

<table class="table">

    <thead>

        <tr>

        <th>ID</th>

        <th>Name</th>

        <th>Course</th>

        <th>Semester</th>

        <th>Contact</th>

        <th>address</th>

        <th>age</th>

        <th>Action</th>

        <th>View QR code</th>


    </tr>

    </thead>

    <tbody> 

    <?php 
        include('connect.php');
        if(isset($_GET['search']))
        {
            $filtervalues = $_GET['search'];
            $query = "SELECT * FROM students WHERE CONCAT(id,full_name,course,semester,student_address) LIKE '%$filtervalues%'";
            $query_run = mysqli_query($conn, $query);

            if(mysqli_num_rows($query_run) > 0)
            {
                foreach($query_run as $items)
                {
                    ?>
                    <tr>
                        <td><?= $items['id']; ?></td>
                        <td><?= $items['full_name']; ?></td>
                        <td><?= $items['course']; ?></td>
                        <td><?= $items['semester']; ?></td>
                        <td><?= $items['phone']; ?></td>
                        <td><?= $items['student_address']; ?></td>
                        <td><?= $items['age']; ?></td>
                        <td><a class="btn btn-info" href="update.php?id=<?php echo $items['id']; ?>">Edit</a>&nbsp;<a class="btn btn-danger" href="delete.php?id=<?php echo $items['id']; ?>" onclick="return confirmDelete();">Delete</a></td>
                        <td> <a class="btn btn-info" href="imageview.php?id=<?php echo $items['id']; ?>&name=<?php echo $items['full_name']; ?>">View</a></td>
                    </tr>
                    <?php
                }
            }

            
            else
            {
                header("location:view.php?error=true");
                exit(0);
            }
        }

        if(isset($GET))
        {
            echo('error');
        }
        ?>
        
        
        

    </tbody>

</table>

    </div> 

   
</body>

</html>
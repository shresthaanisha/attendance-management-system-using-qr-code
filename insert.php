<?php


include('connect.php');
session_start();

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $text = $_POST['text'];

        list($id, $sname) = explode('_', $text);

        // Check if the student with the given ID exists
        $checkSql = "SELECT * FROM students WHERE id = '$id'";
        $result = $conn->query($checkSql);


        if ($result->num_rows > 0) {
            // Student exists, proceed to insert into attendance table
            $check2 = "SELECT id FROM attendance WHERE DATE(time_in)=CURDATE() AND id = '$id'";
            $result2 = $conn->query($check2);

            if($result2-> num_rows == 0)
            {
                $sql = "INSERT INTO attendance (id, Sname, present_status) VALUES ('$id', '$sname' , '1')";
                // $update_query = "INSERT INTO attendance set present_status = '1'";
                // $update_query_run = mysqli_query($conn, $update_query);

                if ($conn->query($sql) === TRUE) {
                    // $_SESSION['success'] = 'Attendance recorded successfully';
                    header('location:qr.php?success=true');
                    exit(0);
                } else {
                    $_SESSION['error'] = $conn->error;
                    // header('location:qr.php?er=true');
                    // exit(0);
                }
            }
            else{
                header('location:qr.php?error=true');
                exit(0);
            }

           
        } else {
            // Student does not exist, handle accordingly
            // $_SESSION['error'] = 'Student with ID ' . $id . ' not found';
            header('location: qr.php?na=true');
            exit(0);
        }
    } else {
        http_response_code(405); // Method Not Allowed
        echo 'Invalid request method';
    }

    header("location: qr.php");

                // // At the end of the day, check for missing students in attendance table and insert with present_status 0
                // if (date("H:i:s") >= "16:59:59") {
                //     $currentDate = date("Y-m-d");
    
                //     // Get the list of registered students
                //     $registeredStudents = array();
                //     $registeredStudentsQuery = $conn->query("SELECT id, full_name FROM students");
                //     while ($row = $registeredStudentsQuery->fetch_assoc()) {
                //         $registeredStudents[] = $row['id'];
                //     }
    
                //     // Get the list of students present in the attendance table for the current date
                //     $presentStudents = array();
                //     $presentStudentsQuery = $conn->query("SELECT id,sname FROM attendance WHERE DATE(time_in) = '$currentDate'");
                //     while ($row = $presentStudentsQuery->fetch_assoc()) {
                //         $presentStudents[] = $row['id'];
                //     }
    
                //     // Find missing students and insert them with present_status 0
                //     $missingStudents = array_diff($registeredStudents, $presentStudents);
                //     foreach ($missingStudents as $missingStudent) {
                //         $conn->query("INSERT INTO attendance (id, present_status) VALUES ('$missingStudent', '0')");
                //     }
    
                //     // Clear any existing session messages to avoid confusion
                //     unset($_SESSION['success']);
                //     unset($_SESSION['error']);
                // }
} catch (mysqli_sql_exception $e) {
    if ($e->getCode() == 1062) {
        header("location: qr.php?error1=true");
        exit(0);
    } else {
        // Handle other database-related exceptions
        echo "Database error: " . $e->getMessage();
    }
} finally {
    $conn->close();
}





    

?>



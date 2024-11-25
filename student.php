<?php
session_start();
include('connect.php');
// include('PhpSpreadsheet-master/src/PhpSpreadsheet/Spreadsheet.php');
// require 'vendor/autoload.php';

// use PhpOffice\PhpSpreadsheet\Spreadsheet;
// use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if (!isset($_SESSION['authenticated'])) {
    header("location: login.php");
    exit();
}


$email = $_SESSION['auth_user']['email'];

$statusQuery = $conn->query("SELECT DISTINCT present_status FROM attendance");
$attendanceStatuses = $statusQuery->fetch_all(MYSQLI_ASSOC);


// Fetch all attendance records for the logged-in student using their email
$studentsQuery = $conn->query("SELECT a.*, s.course, s.semester FROM attendance a 
                                JOIN students s ON a.id = s.id
                                WHERE s.email = '$email'");
$students = $studentsQuery->fetch_all(MYSQLI_ASSOC);

// Initialize counters for present and absent days
$presentDays = 0;
$absentDays = 0;

foreach ($students as $student) {
    $presentStatus = $student['present_status'];
    
    if ($presentStatus == '1') {
        $presentDays++;
    } else {
        $absentDays++;
    }
}

if (empty($students)) {
    // } else {
//     $spreadsheet = new Spreadsheet();
//     $sheet = $spreadsheet->getActiveSheet();

    //     $sheet->setCellValue('A1', 'Student ID');
// $sheet->setCellValue('B1', 'Student Name');
// $sheet->setCellValue('C1', 'Date');
// $sheet->setCellValue('D1', 'Time');
// $sheet->setCellValue('E1', 'Status');
// $sheet->setCellValue('F1', 'Course');
// $sheet->setCellValue('G1', 'Semester');

    // // Add data to the worksheet
// $row = 2;
// foreach ($students as $student) {
//     $time_in = $student['time_in'];
//     list($date, $time) = explode(' ', $time_in);

    //     $sheet->setCellValue('A' . $row, $student['id']);
//     $sheet->setCellValue('B' . $row, $student['sname']);
//     $sheet->setCellValue('C' . $row, $date);
//     $sheet->setCellValue('D' . $row, $time);
//     $sheet->setCellValue('E' . $row, ($student['present_status'] == '1') ? 'Present' : 'Absent');
//     $sheet->setCellValue('F' . $row, $student['course']);
//     $sheet->setCellValue('G' . $row, $student['semester']);



    //     // ... Add date and status accordingly

    //     $row++;
//     }

    //     $filename = 'attendance_export.xlsx';
//     $writer = new Xlsx($spreadsheet);
//     $writer->save($filename);

    //     echo "<p><a href='$filename' download>Download Excel</a></p>";
}
?>

<!-- HTML code -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendence Tracker</title>
    
    <link rel="stylesheet" href="css\studentcss.css">
</head>

<body>
    <div class="container">
        
        <div class="title">Attendance Tracker
            
        <script>
            function logout() {
                window.location.href = "stlogout.php";
            }
        </script>
        </div>

         <!-- Display the logged-in user -->
         <div style=" margin-bottom:-17px; margin-top:20px"> Welcome, <?= $_SESSION['auth_user']['username']; ?>!</div>
         <div style=" margin-bottom:-17px; margin-top:20px"> Present Days: <?= $presentDays; ?> | Absent Days: <?= $absentDays; ?></div>


             
        
        <!-- <button onclick="goBack()">Go To Dashboard</button> -->
        <!-- Display the table -->
        <table>
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Student Name</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th>Course</th>
                    <th>Semester</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $student): ?>
                    <tr>
                        <td>
                            <?= $student['id']; ?>
                        </td>
                        <td>
                            <?= $student['sname']; ?>
                        </td>
                        <?php
                        $time_in = $student['time_in'];
                        list($date, $time) = explode(' ', $time_in);

                        $studentId = $student['id'];
                        $statusQuery = $conn->query("SELECT present_status FROM attendance WHERE time_in = '$time_in'    ");
                        $result = $statusQuery->fetch_assoc();
                        $presentStatus = $result['present_status'];
                        ?>
                        <td>
                            <?= $date; ?>
                        </td>
                        <td>
                            <?= $time; ?>
                        </td>
                        <td>
                            <?php if ($presentStatus == '1'): ?>
                                <span class="status-present">Present</span>
                            <?php else: ?>
                                <span class="status-absent">Absent</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?= $student['course']; ?>
                        </td>
                        <td>
                            <?= $student['semester']; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
           <!-- logout button -->
           <button type="button" name="btnsubmit" value="Logout" onclick= "logout()" style="padding: 20px;
                padding: 20px;
                margin-top: 20px;
                margin-bottom: 22px;
                border-radius: 5px;
                border: none;
                background: #95b8d1;
                cursor:pointer;">Log Out</button> 

    </div>

    
</body>

</html>
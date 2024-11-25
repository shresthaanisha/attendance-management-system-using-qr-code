<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Tracker</title>
    <link rel="stylesheet" href="css\record.css">

    <script>
          function goBack() {
          window.location.href = "final.php";
        }
    </script>
</head>

<body>
<div class="container">
    <?php
    session_start();
    // Database connection parameters
    include('connect.php');
    include('PhpSpreadsheet-master/src/PhpSpreadsheet/Spreadsheet.php');
    require 'vendor/autoload.php';

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    
    // Fetch possible attendance statuses from the database
    $statusQuery = $conn->query("SELECT DISTINCT present_status FROM attendance");
    $attendanceStatuses = $statusQuery->fetch_all(MYSQLI_ASSOC);

    // Fetch unique courses and semesters for filter options
    $courseQuery = $conn->query("SELECT DISTINCT course FROM students");
    $courses = $courseQuery->fetch_all(MYSQLI_ASSOC);

    $semQuery = $conn->query("SELECT DISTINCT semester FROM students");
    $semesters = $semQuery->fetch_all(MYSQLI_ASSOC);

    // Filter values from the form
    $filterDate = isset($_POST['filterDate']) ? $_POST['filterDate'] : date('Y-m-d');
    $filterMonth = isset($_POST['filterMonth']) ? $_POST['filterMonth'] : date('Y-m');
    $filterCourse = isset($_POST['filterCourse']) ? $_POST['filterCourse'] : '';
    $filterSemester = isset($_POST['filterSemester']) ? $_POST['filterSemester'] : '';

  // Conditions array for filtering
  $conditions = [];

  if (!empty($filterDate)) {
      $conditions[] = "DATE_FORMAT(a.time_in, '%Y-%m-%d') = '$filterDate'";
  }

  if (!empty($filterMonth) && empty($filterDate)) {
      $conditions[] = "DATE_FORMAT(a.time_in, '%Y-%m') = '$filterMonth'";
  }

  if (!empty($filterCourse)) {
      $conditions[] = "s.course = '$filterCourse'";
  }

  if (!empty($filterSemester)) {
      $conditions[] = "s.semester = '$filterSemester'";
  }

  // Combine conditions with AND
  $filterCondition = implode(' AND ', $conditions);

  // Final SQL query
  $studentsQuery = $conn->query("SELECT a.id, s.full_name, a.time_in, a.present_status, s.course, s.semester 
      FROM attendance a 
      JOIN students s ON a.id = s.id
      WHERE " . ($filterCondition ? $filterCondition : "1"));
  $students = $studentsQuery->fetch_all(MYSQLI_ASSOC);

  $spreadsheet = new Spreadsheet();

  // Add a worksheet
  $sheet = $spreadsheet->getActiveSheet();

  // Add headers to the worksheet
  $sheet->setCellValue('A1', 'Student ID');
  $sheet->setCellValue('B1', 'Student Name');
  $sheet->setCellValue('C1', 'Date');
  $sheet->setCellValue('D1', 'Time');
  $sheet->setCellValue('E1', 'Status');
  $sheet->setCellValue('F1', 'Course');
  $sheet->setCellValue('G1', 'Semester');

  // Add data to the worksheet
  $row = 2;
  foreach ($students as $student) {
      $time_in = $student['time_in'];
      list($date, $time) = explode(' ', $time_in);

      $sheet->setCellValue('A' . $row, $student['id']);
      $sheet->setCellValue('B' . $row, $student['full_name']);
      $sheet->setCellValue('C' . $row, $date);
      $sheet->setCellValue('D' . $row, $time);
      $sheet->setCellValue('E' . $row, ($student['present_status'] == '1') ? 'Present' : 'Absent');
      $sheet->setCellValue('F' . $row, $student['course']);
      $sheet->setCellValue('G' . $row, $student['semester']);

      // ... Add date and status accordingly

      $row++;
  }

  // Save the spreadsheet to a file
  $filename = 'attendance_export.xlsx';
  $writer = new Xlsx($spreadsheet);
  $writer->save($filename);

  echo "<p><a href='$filename' download id>Download Excel</a></p>";

  ?>
    
        <!-- Filter controls -->
        <form method="POST" action="">
            <div class="title">Attendance Tracker</div>

            <div class="bar">
                <div class="box">
                    <label for="filterDate">Filter by Date:</label>
                    <input type="date" id="filterDate" name="filterDate" value="<?= $filterDate ?>">
                </div>
                <div class="box">
                    <label for="filterMonth">Filter by Month:</label>
                    <input type="month" id="filterMonth" name="filterMonth" value="<?= $filterMonth?>">
                </div>

                <div class="box">
                    <label for="filterCourse">Filter by Course:</label>
                    <select name="filterCourse" id="filterCourse">
                        <option value="">All Courses</option>
                        <?php
                            foreach ($courses as $course) {
                            $selected = ($filterCourse == $course['course']) ? 'selected' : '';
                            echo '<option value="' . $course['course'] . '" ' . $selected . '>' . $course['course'] . '</option>';
                            }
                        ?>
                    </select>
                </div>


                <div class="box">
                    <label for="filterSemester">Filter by Semester:</label>
                    <select name="filterSemester" id="filterSemester">
                        <option value="">All Semesters</option>
                        <?php
                        foreach ($semesters as $semester) {
                            $selected = ($filterSemester == $semester['semester'])? 'selected' : '';
                            echo '<option value="' . $semester['semester'] . '" ' . $selected . '>' . $semester['semester'] . '</option>';
                        }
                        ?>
                    </select>
                </div>

                <div class="button">
                <input type="submit" name="btnsubmit" value="Apply Filter">
                </div>
            </div>
        </form>

        <div class="dash">
		<button class="dash" style="
            margin-top: 15px;
            padding: 10px;
            border-radius: 8px; 
        "onclick="goBack()">Go To Dashboard</button>
	</div>


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
                            <?= $student['full_name']; ?>
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



    </div>



</body>

</html>
<?php 
include('connect.php');
require '..login/PhpSpreadsheet-master/src/PhpSpreadsheet/Spreadsheet.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


// ... (Your existing PHP code)

// Create a new Spreadsheet object
$spreadsheet = new Spreadsheet();

// Add a worksheet
$sheet = $spreadsheet->getActiveSheet();

// Add headers to the worksheet
$sheet->setCellValue('A1', 'Student ID');
$sheet->setCellValue('B1', 'Student Name');
$sheet->setCellValue('C1', 'Date');
$sheet->setCellValue('D1', 'Status');

// Add data to the worksheet
$row = 2;
foreach ($students as $student) {
    $sheet->setCellValue('A' . $row, $student['id']);
    $sheet->setCellValue('B' . $row, $student['sname']);
    
    // ... Add date and status accordingly

    $row++;
}

// Save the spreadsheet to a file
$filename = 'attendance_export.xlsx';
$writer = new Xlsx($spreadsheet);
$writer->save($filename);

echo "<p><a href='$filename' download>Download Excel</a></p>";
?>



?>
<?php
session_start();
include "connect.php";

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

if (isset($_GET['id'])) {
    $studentId = $_GET['id'];
    $studentName = $_GET['name'];

    // Use parameterized query to prevent SQL injection
    $sql = "SELECT qrcode FROM students WHERE id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $studentId);
    $stmt->execute();
    
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $qrCode = $row['qrcode'];

        // Display the student information
        echo "<h1>This is the QR code of, $studentName!</h1>";
    } else {
        echo"No qr found";
    }

    $stmt->close();
} else {
    // Redirect if ID is not provided
    header("Location: view.php");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student QR Code</title>
    <link rel="stylesheet" href="css/image.css">
    
</head>

<body>
    <img id="qrCodeImage" src="<?php echo $qrCode; ?>" alt="Student QR Code">
</body>

</html>

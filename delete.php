<?php 

include "connect.php"; 

if (isset($_GET['id'])) {

    $id = $_GET['id'];
        // Fetch the filename from the database before deleting the record
        // $fetchFilenameSql = "SELECT qrcode FROM students WHERE id='$id'";
        // $resultFetch = $conn->query($fetchFilenameSql);
    
        // if ($resultFetch->num_rows > 0) {
        //     $row = $resultFetch->fetch_assoc();
        //     $filename = $row['qrcode'];
    
        //     // Delete the QR code file from the temp folder
        //     if (file_exists($filename) && is_writable($filename)) {
        //         unlink($filename);
        //     } else {
        //         echo "Error: Unable to delete file or file does not exist.";
        //         exit;
        //     }

    $sql = "DELETE FROM `students` WHERE `id`='$id'";

     $result = $conn->query($sql);

     if ($result == TRUE) {
        header('Location: view.php?del=true');

        // echo "Record deleted successfully.";

    }else{

        echo "Error:" . $sql . "<br>" . $conn->error;

    }

} 


?>

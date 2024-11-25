<?php
// Start the session
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
// Redirect to the login page or any other desired page
header("Location: index.php");
exit();
?>
<script>
   // Use JavaScript to clear the browser history
   window.location.replace("index.php");
</script>
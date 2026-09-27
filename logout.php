<?php
// Log the customer out by clearing their session, then go back to the home page
session_start();
session_destroy();
header("Location: index.php");
exit();
?>

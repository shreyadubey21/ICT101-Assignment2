<?php
// db.php - connects to the MySQL database.
// Every page includes this file first.

session_start();

// XAMPP default settings (username "root", no password)
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "paws_polish";

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Could not connect to the database. Make sure MySQL is running in XAMPP and you have imported database/paws_polish.sql.");
}
?>

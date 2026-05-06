<?php
$host = "localhost";
$user = "your_db_username";
$pass = "your_db_password";
$db = "library";

$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
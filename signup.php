<?php
session_start();
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
$username = mysqli_real_escape_string($conn, $_POST["username"]);
$password = $_POST["password"];
$confirm_password = $_POST["confirm_password"];

if ($password != $confirm_password) {
echo "<p style='color:red;'>Passwords do not match!</p>";
} else {
$check_user = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
if (mysqli_num_rows($check_user) > 0) {
echo "<p style='color:red;'>Username already exists!</p>";
} else {
$password = md5($password); // simple hashing
$insert = mysqli_query($conn, "INSERT INTO users (username, password) VALUES ('$username', '$password')");
if ($insert) {
echo "<p style='color:green;'>Account created successfully. <a href='login.php'>Login here</a>.</p>";
exit;
} else {
echo "<p style='color:red;'>Error creating account.</p>";
}
}
}
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Signup</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="centered-form">
<h2>Signup</h2>
<form method="post" action="">
<input type="text" name="username" placeholder="Username" required><br><br>
<input type="password" name="password" placeholder="Password" required><br><br>
<input type="password" name="confirm_password" placeholder="Confirm Password" required><br><br>
<input type="submit" value="Signup">
</form>
<p>Already have an account? <a href="login.php">Login here</a></p>
</div>
</body>
</html>
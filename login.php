<?php
session_start();
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
$username = mysqli_real_escape_string($conn, $_POST["username"]);
$password = md5($_POST["password"]);

$query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND password='$password'");
if (mysqli_num_rows($query) == 1) {
$_SESSION['username'] = $username;
header("Location: index.php");
exit;
} else {
echo "<p style='color:red;'>Invalid username or password.</p>";
}
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="centered-form">
<h2>Login</h2>
<form method="post" action="">
<input type="text" name="username" placeholder="Username" required><br><br>
<input type="password" name="password" placeholder="Password" required><br><br>
<input type="submit" value="Login">
</form>
<p>No account? <a href="signup.php">Signup here</a></p>
</div>
</body>
</html>
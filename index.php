<?php
session_start();
if (!isset($_SESSION['username'])) {
header("Location: login.php");
exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Library Management - Home</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<center><h1>Library Management System</h1></center>
<div class="centered-form">
<h2>Welcome, <?php echo $_SESSION['username']; ?></h2>
<p><a href="students.php">Manage Students</a> | <a href="books.php">Manage Books</a> | <a href="logout.php">Logout</a></p>
</div>
</body>
</html>
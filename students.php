
<?php
session_start();
include "config.php";
if (!isset($_SESSION['username'])) {
header("Location: login.php");
exit;
}

$action = isset($_GET['action']) ? $_GET['action'] : '';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Add or update student
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$name = mysqli_real_escape_string($conn, $_POST['name']);
$email = mysqli_real_escape_string($conn, $_POST['email']);

if ($_POST['id'] == '') {
mysqli_query($conn, "INSERT INTO students (name,email) VALUES ('$name', '$email')");
} else {
$stid = intval($_POST['id']);
mysqli_query($conn, "UPDATE students SET name='$name', email='$email' WHERE id=$stid");
}
header("Location: students.php");
exit;
}

// Delete student
if ($action == 'delete' && $id > 0) {
mysqli_query($conn, "DELETE FROM students WHERE id=$id");
header("Location: students.php");
exit;
}

// Get student for edit
if ($action == 'edit' && $id > 0) {
$res = mysqli_query($conn, "SELECT * FROM students WHERE id=$id");
$student = mysqli_fetch_assoc($res);
}

// Fetch all students
$result = mysqli_query($conn, "SELECT * FROM students");
?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Students</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<center><h1>Library Management System</h1></center>
<div class="centered-form">
<h2>Students</h2>
<table border="1" cellpadding="5" cellspacing="0">
<tr><th>ID</th><th>Name</th><th>Email</th><th>Actions</th></tr>
<?php while ($row = mysqli_fetch_assoc($result)) { ?>
<tr>
<td><?php echo $row['id']; ?></td>
<td><?php echo htmlspecialchars($row['name']); ?></td>
<td><?php echo htmlspecialchars($row['email']); ?></td>
<td>
<a href="students.php?action=edit&id=<?php echo $row['id']; ?>">Edit</a> |
<a href="students.php?action=delete&id=<?php echo $row['id']; ?>" onclick="return confirm('Delete this student?')">Delete</a>
</td>
</tr>
<?php } ?>
</table>

<h3><?php echo ($action == 'edit') ? 'Edit' : 'Add'; ?> Student</h3>
<form method="post" action="students.php">
<input type="hidden" name="id" value="<?php echo isset($student['id']) ? $student['id'] : ''; ?>">
<input type="text" name="name" placeholder="Name" required value="<?php echo isset($student['name']) ? htmlspecialchars($student['name']) : ''; ?>"><br><br>
<input type="email" name="email" placeholder="Email" required value="<?php echo isset($student['email']) ? htmlspecialchars($student['email']) : ''; ?>"><br><br>
<input type="submit" value="<?php echo ($action == 'edit') ? 'Update' : 'Add'; ?>">
</form>
<p><a href="index.php">Back to home</a></p>
</div>
</body>
</html>
<?php
session_start();
include "config.php";
if (!isset($_SESSION['username'])) {
header("Location: login.php");
exit;
}

$action = isset($_GET['action']) ? $_GET['action'] : '';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
$title = mysqli_real_escape_string($conn, $_POST['title']);
$author = mysqli_real_escape_string($conn, $_POST['author']);

if ($_POST['id'] == '') {
mysqli_query($conn, "INSERT INTO books (title,author) VALUES ('$title','$author')");
} else {
$bid = intval($_POST['id']);
mysqli_query($conn, "UPDATE books SET title='$title', author='$author' WHERE id=$bid");
}
header("Location: books.php");
exit;
}

if ($action == 'delete' && $id > 0) {
mysqli_query($conn, "DELETE FROM books WHERE id=$id");
header("Location: books.php");
exit;
}

if ($action == 'edit' && $id > 0) {
$res = mysqli_query($conn, "SELECT * FROM books WHERE id=$id");
$book = mysqli_fetch_assoc($res);
}

$result = mysqli_query($conn, "SELECT * FROM books");
?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Books</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<center><h1>Library Management System</h1></center>
<div class="centered-form">
<h2>Books</h2>
<table border="1" cellpadding="5" cellspacing="0">
<tr><th>ID</th><th>Title</th><th>Author</th><th>Actions</th></tr>
<?php while ($row = mysqli_fetch_assoc($result)) { ?>
<tr>
<td><?php echo $row['id']; ?></td>
<td><?php echo htmlspecialchars($row['title']); ?></td>
<td><?php echo htmlspecialchars($row['author']); ?></td>
<td>
<a href="books.php?action=edit&id=<?php echo $row['id']; ?>">Edit</a> |
<a href="books.php?action=delete&id=<?php echo $row['id']; ?>" onclick="return confirm('Delete this book?')">Delete</a>
</td>
</tr>
<?php } ?>
</table>

<h3><?php echo ($action == 'edit') ? 'Edit' : 'Add'; ?> Book</h3>
<form method="post" action="books.php">
<input type="hidden" name="id" value="<?php echo isset($book['id']) ? $book['id'] : ''; ?>">
<input type="text" name="title" placeholder="Title" required value="<?php echo isset($book['title']) ? htmlspecialchars($book['title']) : ''; ?>"><br><br>
<input type="text" name="author" placeholder="Author" required value="<?php echo isset($book['author']) ? htmlspecialchars($book['author']) : ''; ?>"><br><br>
<input type="submit" value="<?php echo ($action == 'edit') ? 'Update' : 'Add'; ?>">
</form>
<p><a href="index.php">Back to home</a></p>
</div>
</body>
</html>
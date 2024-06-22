<?php
// Connect to the database
$mysqli = new mysqli("localhost", "username", "password", "school_db");

$id = $_GET['id'];

// Fetch student data to get the image path
$sql = "SELECT image FROM student WHERE id = $id";
$result = $mysqli->query($sql);
$student = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Delete the student image from the server
    if (file_exists("uploads/" . $student['image'])) {
        unlink("uploads/" . $student['image']);
    }

    // Delete the student record from the database
    $sql = "DELETE FROM student WHERE id = $id";

    if ($mysqli->query($sql) === TRUE) {
        header('Location: index.php');
    } else {
        echo "Error: " . $sql . "<br>" . $mysqli->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Student</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1>Delete Student</h1>
    <form method="post">
        <p>Are you sure you want to delete this student?</p>
        <button type="submit" class="btn btn-danger">Delete</button>
        <a href="index.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>

<?php
$mysqli->close();
?>

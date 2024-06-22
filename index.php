<?php
$mysqli = new mysqli("localhost", "root", "", "school_db");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$sql = "SELECT student.id, student.name, student.email, student.created_at, student.image, classes.name as class_name 
        FROM student 
        JOIN classes ON student.class_id = classes.class_id";
$result = $mysqli->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <h1 class="mt-4">Student List</h1>
    <a href="create.php" class="btn btn-primary mb-3">Add New Student</a>
    <table class="table table-bordered">
        <thead class="thead-dark">
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Class</th>
            <th>Created At</th>
            <th>Image</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><?php echo htmlspecialchars($row['class_name']); ?></td>
                <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                <td><img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="Student Image" width="50"></td>
                <td>
                    <a href="view.php?id=<?php echo $row['id']; ?>" class="btn btn-info btn-sm">View</a>
                    <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
</body>
</html>

<?php
$mysqli->close();
?>

<?php
$mysqli = new mysqli("localhost", "root", "", "school_db");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $sql = "INSERT INTO classes (name) VALUES ('$name')";
    $mysqli->query($sql);
}

$classes_result = $mysqli->query("SELECT * FROM classes");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Classes</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <h1 class="mt-4">Manage Classes</h1>
    <form action="classes.php" method="POST">
        <div class="form-group">
            <label for="name">Class Name</label>
            <input type="text" name="name" class="form-control" id="name" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Class</button>
    </form>
    <h2 class="mt-4">Classes List</h2>
    <table class="table table-bordered">
        <thead class="thead-dark">
        <tr>
            <th>Class ID</th>
            <th>Class Name</th>
            <th>Created At</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($class = $classes_result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo htmlspecialchars($class['class_id']); ?></td>
                <td><?php echo htmlspecialchars($class['name']); ?></td>
                <td><?php echo htmlspecialchars($class['created_at']); ?></td>
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

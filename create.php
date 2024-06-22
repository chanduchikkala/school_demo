<?php
$mysqli = new mysqli("localhost", "root", "", "school_db");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$classes_result = $mysqli->query("SELECT * FROM classes");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $class_id = $_POST['class_id'];
    $image = $_FILES['image']['name'];

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($image);
    move_uploaded_file($_FILES['image']['tmp_name'], $target_file);

    $sql = "INSERT INTO student (name, email, address, class_id, image) VALUES ('$name', '$email', '$address', '$class_id', '$image')";
    $mysqli->query($sql);
    header("Location: index.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Student</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <h1 class="mt-4">Create Student</h1>
    <form action="create.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" id="name" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" id="email" required>
        </div>
        <div class="form-group">
            <label for="address">Address</label>
            <textarea name="address" class="form-control" id="address" required></textarea>
        </div>
        <div class="form-group">
            <label for="class_id">Class</label>
            <select name="class_id" class="form-control" id="class_id" required>
                <?php while ($class = $classes_result->fetch_assoc()) { ?>
                    <option value="<?php echo $class['class_id']; ?>"><?php echo $class['name']; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="image" class="form-control-file" id="image" accept="image/*" required>
        </div>
        <button type="submit" class="btn btn-primary">Create Student</button>
    </form>
</div>
</body>
</html>

<?php
$mysqli->close();
?>

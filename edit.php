<?php
// Connect to the database
$mysqli = new mysqli("localhost", "username", "password", "school_db");

$id = $_GET['id'];

// Fetch current student data
$sql = "SELECT * FROM student WHERE id = $id";
$result = $mysqli->query($sql);
$student = $result->fetch_assoc();

// Fetch classes for dropdown
$class_result = $mysqli->query("SELECT * FROM classes");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $class_id = $_POST['class_id'];
    $image = $student['image'];

    // Image upload
    if ($_FILES['image']['name']) {
        $image = $_FILES['image']['name'];
        $target = "uploads/" . basename($image);

        // Check if the file is a valid image
        $imageFileType = strtolower(pathinfo($target, PATHINFO_EXTENSION));
        if ($imageFileType != "jpg" && $imageFileType != "png") {
            echo "Sorry, only JPG & PNG files are allowed.";
            exit();
        }

        if (!move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            echo "Sorry, there was an error uploading your file.";
            exit();
        }
    }

    $sql = "UPDATE student SET name='$name', email='$email', address='$address', class_id=$class_id, image='$image' WHERE id=$id";

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
    <title>Edit Student</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1>Edit Student</h1>
    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="<?php echo $student['name']; ?>" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?php echo $student['email']; ?>" required>
        </div>
        <div class="form-group">
            <label>Address</label>
            <textarea name="address" class="form-control"><?php echo $student['address']; ?></textarea>
        </div>
        <div class="form-group">
            <label>Class</label>
            <select name="class_id" class="form-control">
                <?php while ($row = $class_result->fetch_assoc()) { ?>
                    <option value="<?php echo $row['class_id']; ?>" <?php if ($row['class_id'] == $student['class_id']) echo 'selected'; ?>><?php echo $row['name']; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label>Image</label>
            <input type="file" name="image" class="form-control">
            <img src="uploads/<?php echo $student['image']; ?>" alt="Current Image" width="100">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
</body>
</html>

<?php
$mysqli->close();
?>

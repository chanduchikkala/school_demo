<?php
// Connect to the database
$mysqli = new mysqli("localhost", "username", "password", "school_db");

$id = $_GET['id'];

// Fetch student data with class name
$sql = "SELECT student.name, student.email, student.address, student.created_at, student.image, classes.name as class_name 
        FROM student 
        JOIN classes ON student.class_id = classes.class_id 
        WHERE student.id = $id";
$result = $mysqli->query($sql);
$student = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Student</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1>View Student</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title"><?php echo $student['name']; ?></h5>
            <p class="card-text">Email: <?php echo $student['email']; ?></p>
            <p class="card-text">Address: <?php echo $student['address']; ?></p>
            <p class="card-text">Class: <?php echo $student['class_name']; ?></p>
            <p class="card-text">Created At: <?php echo $student['created_at']; ?></p>
            <img src="uploads/<?php echo $student['image']; ?>" alt="Student Image" class="img-thumbnail">
            <a href="index.php" class="btn btn-primary">Back</a>
        </div>
    </div>
</div>
</body>
</html>

<?php
$mysqli->close();
?>

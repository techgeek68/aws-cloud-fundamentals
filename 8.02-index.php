<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'config.php';

// Create students table if it doesn't exist
$tableSql = "CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    age INT,
    college_name VARCHAR(100),
    program_name VARCHAR(100),
    year INT,
    semester VARCHAR(20)
)";
$conn->query($tableSql);

// Handle insert form submission
$insertMsg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_student'])) {
    $fn = $conn->real_escape_string($_POST['first_name']);
    $ln = $conn->real_escape_string($_POST['last_name']);
    $age = intval($_POST['age']);
    $college = $conn->real_escape_string($_POST['college_name']);
    $program = $conn->real_escape_string($_POST['program_name']);
    $year = intval($_POST['year']);
    $semester = $conn->real_escape_string($_POST['semester']);

    $sql = "INSERT INTO students (first_name, last_name, age, college_name, program_name, year, semester)
            VALUES ('$fn', '$ln', $age, '$college', '$program', $year, '$semester')";
    if ($conn->query($sql)) {
        $insertMsg = "<span style='color: green;'>Student added successfully!</span>";
    } else {
        $insertMsg = "<span style='color: red;'>Error: {$conn->error}</span>";
    }
}

// Handle delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_student'])) {
    $id = intval($_POST['student_id']);
    $sql = "DELETE FROM students WHERE id=$id";
    if ($conn->query($sql)) {
        $insertMsg = "<span style='color: green;'>Student deleted successfully!</span>";
    } else {
        $insertMsg = "<span style='color: red;'>Error deleting student: {$conn->error}</span>";
    }
}

// Handle edit - show edit form
$editStudent = null;
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $res = $conn->query("SELECT * FROM students WHERE id=$id");
    if ($res && $res->num_rows > 0) {
        $editStudent = $res->fetch_assoc();
    }
}

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_student'])) {
    $id = intval($_POST['student_id']);
    $fn = $conn->real_escape_string($_POST['first_name']);
    $ln = $conn->real_escape_string($_POST['last_name']);
    $age = intval($_POST['age']);
    $college = $conn->real_escape_string($_POST['college_name']);
    $program = $conn->real_escape_string($_POST['program_name']);
    $year = intval($_POST['year']);
    $semester = $conn->real_escape_string($_POST['semester']);

    $sql = "UPDATE students SET first_name='$fn', last_name='$ln', age=$age, college_name='$college', program_name='$program', year=$year, semester='$semester' WHERE id=$id";
    if ($conn->query($sql)) {
        $insertMsg = "<span style='color: green;'>Student updated successfully!</span>";
    } else {
        $insertMsg = "<span style='color: red;'>Error updating student: {$conn->error}</span>";
    }
}

// Handle search
$searchResult = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search_student'])) {
    $fn = $conn->real_escape_string($_POST['search_first_name']);
    $ln = $conn->real_escape_string($_POST['search_last_name']);

    $sql = "SELECT * FROM students WHERE first_name='$fn' AND last_name='$ln' LIMIT 1";
    $res = $conn->query($sql);
    if ($res && $res->num_rows > 0) {
        $student = $res->fetch_assoc();
        $searchResult = "<h3>Student Found:</h3>
        <ul>
            <li>First Name: {$student['first_name']}</li>
            <li>Last Name: {$student['last_name']}</li>
            <li>Age: {$student['age']}</li>
            <li>College Name: {$student['college_name']}</li>
            <li>Program Name: {$student['program_name']}</li>
            <li>Year: {$student['year']}</li>
            <li>Semester: {$student['semester']}</li>
        </ul>";
    } else {
        $searchResult = "<span style='color: red;'>No student found with that name.</span>";
    }
}

// Get all students for display
$students = [];
$res = $conn->query("SELECT * FROM students ORDER BY id DESC");
if ($res) {
    while ($row = $res->fetch_assoc()) {
        $students[] = $row;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Database Web App</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        form { margin-bottom: 20px; padding: 15px; border: 1px solid #ccc; width: 350px;}
        h2 { margin-top: 0; }
        table { border-collapse: collapse; width: 90%; }
        th, td { border: 1px solid #ccc; padding: 8px; }
        th { background: #f1f1f1; }
        .btn { padding: 4px 10px; cursor: pointer; }
        .edit-link { color: #2980b9; text-decoration: none; }
        .del-btn { background: #e74c3c; color: white; border: none; }
    </style>
</head>
<body>
    <h1>Student Database Web App</h1>

    <?php echo $insertMsg; ?>

    <?php if ($editStudent): ?>
        <h2>Edit Student</h2>
        <form method="post">
            <input type="hidden" name="student_id" value="<?php echo $editStudent['id']; ?>">
            <label>First Name: <input type="text" name="first_name" required value="<?php echo htmlspecialchars($editStudent['first_name']); ?>"></label><br><br>
            <label>Last Name: <input type="text" name="last_name" required value="<?php echo htmlspecialchars($editStudent['last_name']); ?>"></label><br><br>
            <label>Age: <input type="number" name="age" required value="<?php echo htmlspecialchars($editStudent['age']); ?>"></label><br><br>
            <label>College Name: <input type="text" name="college_name" required value="<?php echo htmlspecialchars($editStudent['college_name']); ?>"></label><br><br>
            <label>Program Name: <input type="text" name="program_name" required value="<?php echo htmlspecialchars($editStudent['program_name']); ?>"></label><br><br>
            <label>Year: <input type="number" name="year" required value="<?php echo htmlspecialchars($editStudent['year']); ?>"></label><br><br>
            <label>Semester: <input type="text" name="semester" required value="<?php echo htmlspecialchars($editStudent['semester']); ?>"></label><br><br>
            <input type="submit" name="update_student" value="Update Student" class="btn">
            <a href="index.php" class="btn" style="background:#ccc;color:black;">Cancel</a>
        </form>
    <?php else: ?>
        <h2>Add New Student</h2>
        <form method="post">
            <label>First Name: <input type="text" name="first_name" required></label><br><br>
            <label>Last Name: <input type="text" name="last_name" required></label><br><br>
            <label>Age: <input type="number" name="age" required></label><br><br>
            <label>College Name: <input type="text" name="college_name" required></label><br><br>
            <label>Program Name: <input type="text" name="program_name" required></label><br><br>
            <label>Year: <input type="number" name="year" required></label><br><br>
            <label>Semester: <input type="text" name="semester" required></label><br><br>
            <input type="submit" name="add_student" value="Add Student" class="btn">
        </form>
    <?php endif; ?>

    <h2>Search Student</h2>
    <form method="post">
        <label>First Name: <input type="text" name="search_first_name" required></label><br><br>
        <label>Last Name: <input type="text" name="search_last_name" required></label><br><br>
        <input type="submit" name="search_student" value="Search" class="btn">
    </form>
    <?php echo $searchResult; ?>

    <?php if (count($students) > 0): ?>
        <h2>All Students</h2>
        <table>
            <tr>
                <th>ID</th><th>First Name</th><th>Last Name</th><th>Age</th><th>College Name</th>
                <th>Program Name</th><th>Year</th><th>Semester</th><th>Actions</th>
            </tr>
            <?php foreach ($students as $student): ?>
                <tr>
                    <td><?php echo $student['id']; ?></td>
                    <td><?php echo htmlspecialchars($student['first_name']); ?></td>
                    <td><?php echo htmlspecialchars($student['last_name']); ?></td>
                    <td><?php echo htmlspecialchars($student['age']); ?></td>
                    <td><?php echo htmlspecialchars($student['college_name']); ?></td>
                    <td><?php echo htmlspecialchars($student['program_name']); ?></td>
                    <td><?php echo htmlspecialchars($student['year']); ?></td>
                    <td><?php echo htmlspecialchars($student['semester']); ?></td>
                    <td>
                        <a href="?edit=<?php echo $student['id']; ?>" class="edit-link btn">Edit</a>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="student_id" value="<?php echo $student['id']; ?>">
                            <button type="submit" name="delete_student" class="del-btn btn" onclick="return confirm('Delete this student?');">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No students found.</p>
    <?php endif; ?>

</body>
</html>

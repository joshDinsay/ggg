<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbTest";

// Enable MySQLi reporting for debugging during development
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Fetch data from tblStudent table
    $sql = "SELECT * FROM tblStudent";
    $result = $conn->query($sql);

    // Prepare an array to store student data
    $students = [];

    while ($row = $result->fetch_assoc()) {
        $students[] = [
            "ID" => $row["ID"],
            "Lastname" => htmlspecialchars($row["Lastname"]),
            "Firstname" => htmlspecialchars($row["Firstname"]),
            "Course" => htmlspecialchars($row["Course"]),
            "Yr" => htmlspecialchars($row["Yr"]),
            "Section" => htmlspecialchars($row["Section"])
        ];
    }
} catch (Exception $e) {
    // Handle connection errors
    die("Database connection failed: " . $e->getMessage());
} finally {
    // Close the database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Records Database</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            color: white;
            background-color: #0a0a23;
            text-align: center;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #1a1a3d;
            border-radius: 8px;
        }
        .accordion-button {
            background-color: #2a2a5c;
            color: white;
        }
        .accordion-button:not(.collapsed) {
            background-color: #4a4a88;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        ul li {
            padding: 5px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="accordion" id="accordionExample">
            <?php foreach ($students as $index => $student): ?>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading<?= $index ?>">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $index ?>" aria-expanded="true" aria-controls="collapse<?= $index ?>">
                            <?= $student["Lastname"] ?>, <?= $student["Firstname"] ?>
                        </button>
                    </h2>
                    <div id="collapse<?= $index ?>" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <ol>
                                <li><strong>Course:</strong> <?= $student["Course"] ?></li>
                                <li><strong>Year:</strong> <?= $student["Yr"] ?></li>
                                <li><strong>Section:</strong> <?= $student["Section"] ?></li>
                            </ol>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

    <script>
        // Convert the PHP array of students to JavaScript
        const students = <?= json_encode($students, JSON_PRETTY_PRINT) ?>;
        
        // Log the student data for debugging
        console.log("Student Data:", students);
    </script>
</body>
</html>

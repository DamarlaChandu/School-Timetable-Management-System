<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "school_timetable";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Add Timetable</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(to right, #e3f2fd, #ffffff);
      margin: 0;
      padding: 0;
    }

    header {
      background-color: #1976d2;
      color: white;
      padding: 1.5rem;
      text-align: center;
      box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    }

    .container {
      max-width: 600px;
      margin: 2rem auto;
      background: white;
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    h2 {
      text-align: center;
      color: #1976d2;
      margin-bottom: 1.5rem;
    }

    form label {
      display: block;
      margin-bottom: 0.5rem;
      font-weight: 600;
    }

    form select, form input[type="number"] {
      width: 100%;
      padding: 0.75rem;
      margin-bottom: 1rem;
      border: 1px solid #ccc;
      border-radius: 10px;
      font-size: 1rem;
    }

    form input[type="submit"] {
      width: 100%;
      padding: 0.75rem;
      background-color: #1976d2;
      color: white;
      border: none;
      border-radius: 10px;
      font-size: 1rem;
      font-weight: bold;
      cursor: pointer;
    }

    form input[type="submit"]:hover {
      background-color: #0d47a1;
    }

    .message {
      text-align: center;
      font-weight: bold;
      margin-top: 1rem;
    }

    .success { color: green; }
    .error { color: red; }
  </style>
</head>
<body>

  <header>
    <h1>📅 Add Class Timetable</h1>
  </header>

  <div class="container">
    <h2>Schedule a Class Period</h2>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $class = $_POST['class'];
      $day = $_POST['day'];
      $period = $_POST['period'];
      $subject_id = $_POST['subject_id'];
      $teacher_id = $_POST['teacher_id'];

      $sql = "INSERT INTO timetable (class, day_of_week, period, subject_id, teacher_id) 
              VALUES ($class, '$day', $period, $subject_id, $teacher_id)";
      if ($conn->query($sql) === TRUE) {
        echo "<p class='message success'>Timetable entry added successfully.</p>";
      } else {
        echo "<p class='message error'>Error: " . $conn->error . "</p>";
      }
    }
    ?>

    <form method="POST" action="">
      <label>Class:</label>
      <select name="class" id="classSelect" required onchange="filterOptions()">
        <option value="">--Select Class--</option>
        <?php for ($i = 6; $i <= 10; $i++) echo "<option value='$i'>Class $i</option>"; ?>
      </select>

      <label>Day:</label>
      <select name="day" required>
        <option value="Monday">Monday</option>
        <option value="Tuesday">Tuesday</option>
        <option value="Wednesday">Wednesday</option>
        <option value="Thursday">Thursday</option>
        <option value="Friday">Friday</option>
      </select>

      <label>Period Number:</label>
      <input type="number" name="period" min="1" max="8" required>

      <label>Subject:</label>
      <select name="subject_id" id="subjectSelect" required>
        <option value="">--Select Subject--</option>
        <?php
        $subjects = [];
        $result = $conn->query("SELECT id, name, class FROM subjects");
        while ($row = $result->fetch_assoc()) {
          $subjects[] = $row;
          echo "<option value='{$row['id']}' data-class='{$row['class']}'>Class {$row['class']} - {$row['name']}</option>";
        }
        ?>
      </select>

      <label>Teacher:</label>
      <select name="teacher_id" id="teacherSelect" required>
        <option value="">--Select Teacher--</option>
        <?php
        $teachers = [];
        $result = $conn->query("SELECT id, name, class, subject FROM teachers");
        while ($row = $result->fetch_assoc()) {
          $teachers[] = $row;
          echo "<option value='{$row['id']}' data-class='{$row['class']}'>Class {$row['class']} - {$row['subject']} - {$row['name']}</option>";
        }
        ?>
      </select>

      <input type="submit" value="Add Timetable Entry">
    </form>
  </div>

  <script>
    function filterOptions() {
      const selectedClass = document.getElementById("classSelect").value;

      const subjectOptions = document.querySelectorAll("#subjectSelect option");
      subjectOptions.forEach(option => {
        if (!option.value) return;
        option.style.display = option.getAttribute("data-class") === selectedClass ? "block" : "none";
      });

      const teacherOptions = document.querySelectorAll("#teacherSelect option");
      teacherOptions.forEach(option => {
        if (!option.value) return;
        option.style.display = option.getAttribute("data-class") === selectedClass ? "block" : "none";
      });

      document.getElementById("subjectSelect").value = "";
      document.getElementById("teacherSelect").value = "";
    }
  </script>

</body>
</html>

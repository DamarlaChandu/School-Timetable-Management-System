<?php
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
  <title>📋 Attendance</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(to right, #e0f7fa, #fff);
      margin: 0;
      padding: 0;
    }
    header {
      background-color: #007BFF;
      color: white;
      padding: 1.5rem;
      text-align: center;
      box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    }
    .container {
      max-width: 800px;
      margin: 2rem auto;
      background: white;
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    h1, h2 {
      text-align: center;
      color: #007BFF;
    }
    form label {
      display: block;
      margin-bottom: 0.5rem;
      font-weight: 600;
    }
    form input[type="text"],
    form input[type="date"],
    form select {
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
      background-color: #007BFF;
      color: white;
      border: none;
      border-radius: 10px;
      font-size: 1rem;
      font-weight: bold;
      cursor: pointer;
    }
    form input[type="submit"]:hover {
      background-color: #0056b3;
    }
    .success {
      text-align: center;
      color: green;
      margin-top: 1rem;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 1rem;
    }
    table th, table td {
      border: 1px solid #ddd;
      padding: 0.75rem;
      text-align: left;
    }
    table th {
      background-color: #f2f2f2;
    }
  </style>
</head>
<body>
  <header><h1 style="color:white">📋 Mark Attendance</h1></header>
  <div class="container">
    <form method="POST" action="">
      <label>Select Class:</label>
      <select name="class" required>
        <?php for ($i = 6; $i <= 10; $i++) echo "<option value='$i'>Class $i</option>"; ?>
      </select>

      <label>Date:</label>
      <input type="date" name="attendance_date" required>

      <input type="submit" name="load_students" value="Load Students">
    </form>

    <?php
    if (isset($_POST['load_students'])) {
      $class = $_POST['class'];
      $attendance_date = $_POST['attendance_date'];

      $students = $conn->query("SELECT * FROM students WHERE class = $class");
      if ($students->num_rows > 0) {
        echo "<form method='POST' action=''>
                <input type='hidden' name='class' value='$class'>
                <input type='hidden' name='attendance_date' value='$attendance_date'>
                <table>
                  <tr><th>Student</th><th>Status</th></tr>";
        while ($row = $students->fetch_assoc()) {
          echo "<tr>
                  <td>{$row['name']}<input type='hidden' name='student_ids[]' value='{$row['id']}'></td>
                  <td>
                    <select name='status[{$row['id']}]'>
                      <option value='Present'>Present</option>
                      <option value='Absent'>Absent</option>
                    </select>
                  </td>
                </tr>";
        }
        echo "</table><br><input type='submit' name='submit_attendance' value='Save Attendance'></form>";
      } else {
        echo "<p>No students found for Class $class</p>";
      }
    }

    if (isset($_POST['submit_attendance'])) {
      $attendance_date = $_POST['attendance_date'];
      $student_ids = $_POST['student_ids'];
      $status_arr = $_POST['status'];

      foreach ($student_ids as $id) {
        $status = $status_arr[$id];
        // Removed 'class' from the INSERT query
        $conn->query("INSERT INTO attendance (student_id, attendance_date, status)
                      VALUES ($id, '$attendance_date', '$status')");
      }
      echo "<p class='success'>Attendance saved successfully!</p>";
    }
    ?>
  </div>
</body>
</html>

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
  <title>📅 View Timetable</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(to right, #f0f8ff, #ffffff);
      margin: 0;
      padding: 0;
    }
    header {
      background-color: #007BFF;
      color: white;
      padding: 1.5rem;
      text-align: center;
      font-size: 1.5rem;
      box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    }
    .container {
      max-width: 900px;
      margin: 2rem auto;
      background-color: #fff;
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    label, select {
      font-weight: 600;
      margin-bottom: 1rem;
    }
    select {
      padding: 0.5rem;
      font-size: 1rem;
      border-radius: 8px;
      margin-left: 0.5rem;
    }
    input[type="submit"] {
      padding: 0.6rem 1.2rem;
      font-size: 1rem;
      background-color: #007BFF;
      color: white;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      margin-top: 1rem;
    }
    input[type="submit"]:hover {
      background-color: #007BFF;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 1.5rem;
    }
    th, td {
      border: 1px solid #ddd;
      padding: 0.75rem;
      text-align: center;
    }
    th {
      background-color: #f2f2f2;
      color: #333;
    }
  </style>
</head>
<body>
  <header>📅 View Class Schedule</header>
  <div class="container">
    <form method="POST">
      <label>Select Class:</label>
      <select name="class" required>
        <?php for ($i = 6; $i <= 10; $i++) echo "<option value='$i'>Class $i</option>"; ?>
      </select>
      <input type="submit" name="view" value="View Timetable">
    </form>

    <?php
    if (isset($_POST['view'])) {
      $class = $_POST['class'];

      $result = $conn->query("SELECT * FROM timetable WHERE class = $class ORDER BY FIELD(day, 'Monday','Tuesday','Wednesday','Thursday','Friday','Saturday')");

      if ($result->num_rows > 0) {
        echo "<table>
                <tr><th>Day</th><th>9-10</th><th>10-11</th><th>11-12</th><th>12-1</th><th>2-3</th><th>3-4</th></tr>";

        while ($row = $result->fetch_assoc()) {
          echo "<tr>
                  <td>{$row['day']}</td>
                  <td>{$row['period1']}</td>
                  <td>{$row['period2']}</td>
                  <td>{$row['period3']}</td>
                  <td>{$row['period4']}</td>
                  <td>{$row['period5']}</td>
                  <td>{$row['period6']}</td>
                </tr>";
        }

        echo "</table>";
      } else {
        echo "<p>No schedule found for Class $class.</p>";
      }
    }
    ?>
  </div>
</body>
</html>

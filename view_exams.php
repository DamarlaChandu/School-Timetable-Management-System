<?php
// DB Connection
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
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>View Scheduled Exams</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f4f6f9;
      margin: 0;
      padding: 0;
    }

    header {
      background-color: #007bff;
      color: white;
      padding: 1.5rem;
      text-align: center;
    }

    .container {
      max-width: 800px;
      margin: 2rem auto;
      background: white;
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    h2 {
      text-align: center;
      color: #007bff;
      margin-bottom: 1.5rem;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    table, th, td {
      border: 1px solid #ddd;
    }

    th, td {
      padding: 12px;
      text-align: center;
    }

    th {
      background-color: #007bff;
      color: white;
    }

    tr:nth-child(even) {
      background-color: #f9f9f9;
    }
  </style>
</head>
<body>

<header><h1>📚 Scheduled Exams</h1></header>

<div class="container">
  <h2>Upcoming Exams</h2>

  <?php
  $sql = "SELECT exams.class, teachers.subject, exams.exam_date
          FROM exams
          JOIN teachers ON exams.subject_id = teachers.id
          ORDER BY exams.exam_date ASC";

  $result = $conn->query($sql);

  if ($result->num_rows > 0): ?>
    <table>
      <tr>
        <th>Class</th>
        <th>Subject</th>
        <th>Exam Date</th>
      </tr>
      <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td>Class <?php echo $row["class"]; ?></td>
          <td><?php echo $row["subject"]; ?></td>
          <td><?php echo $row["exam_date"]; ?></td>
        </tr>
      <?php endwhile; ?>
    </table>
  <?php else: ?>
    <p style="text-align:center; color: red;">No exams scheduled yet.</p>
  <?php endif; ?>
</div>

</body>
</html>

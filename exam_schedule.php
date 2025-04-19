<?php
// DB connection
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
  <title>Schedule Exam</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(to right, #f0f8ff, #fff);
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
      max-width: 600px;
      margin: 2rem auto;
      background: white;
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    h2 {
      text-align: center;
      color: #007BFF;
      margin-bottom: 1.5rem;
    }

    form label {
      display: block;
      margin-bottom: 0.5rem;
      font-weight: 600;
    }

    form select,
    form input[type="date"],
    form input[type="text"] {
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
      background-color: #007BFF;
    }

    .success {
      text-align: center;
      color: green;
      margin-top: 1rem;
    }

    .error {
      text-align: center;
      color: red;
      margin-top: 1rem;
    }
  </style>
</head>
<body>

  <header><h1>📝 Schedule Exam</h1></header>

  <div class="container">
    <h2>Set Exam Date for Subject</h2>
    <form method="POST" action="">
      <label>Class:</label>
      <select name="class" id="classSelect" required>
        <option value="">--Select Class--</option>
        <?php for ($i = 6; $i <= 10; $i++) echo "<option value='$i'>Class $i</option>"; ?>
      </select>

      <label>Subject:</label>
      <select name="subject_id" id="subjectSelect" required>
        <option value="">--Select Subject--</option>
      </select>

      <label>Exam Date:</label>
      <input type="date" name="exam_date" required>

      <input type="submit" value="Schedule Exam">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $class = $_POST['class'];
      $subject_id = $_POST['subject_id'];
      $exam_date = $_POST['exam_date'];

      $sql = "INSERT INTO exams (class, subject_id, exam_date) VALUES ($class, $subject_id, '$exam_date')";
      echo $conn->query($sql)
        ? "<p class='success'>✅ Exam scheduled successfully.</p>"
        : "<p class='error'>❌ Error: " . $conn->error . "</p>";
    }
    ?>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const classSelect = document.getElementById('classSelect');
      const subjectSelect = document.getElementById('subjectSelect');

      classSelect.addEventListener('change', () => {
        const classId = classSelect.value;
        subjectSelect.innerHTML = '<option>Loading...</option>';

        fetch('get_subjects.php?class=' + classId)
          .then(response => response.json())
          .then(data => {
            subjectSelect.innerHTML = '<option value="">--Select Subject--</option>';
            data.forEach(subject => {
              const option = document.createElement('option');
              option.value = subject.id;
              option.textContent = subject.name;
              subjectSelect.appendChild(option);
            });
          });
      });
    });
  </script>

</body>
</html>

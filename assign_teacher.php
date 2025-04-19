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
<html>
<head>
  <title>Assign Teachers</title>
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

    form input[type="text"],
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

    .message {
      text-align: center;
      font-weight: bold;
      margin-top: 1rem;
    }

    .success {
      color: green;
    }

    .error {
      color: red;
    }
  </style>
</head>
<body>

  <header>
    <h1>👩‍🏫 Assign Teachers</h1>
  </header>

  <div class="container">
    <h2>Assign Teacher to Subject & Class</h2>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $class = $_POST['class'];
      $subject = $_POST['subject'];
      $teacher_name = $_POST['teacher_name'];

      $sql = "INSERT INTO teachers (name, subject, class) VALUES ('$teacher_name', '$subject', $class)";
      if ($conn->query($sql) === TRUE) {
        echo "<p class='message success'>Teacher assigned successfully.</p>";
      } else {
        echo "<p class='message error'>Error: " . $conn->error . "</p>";
      }
    }
    ?>

    <form method="POST" action="">
      <label>Class:</label>
      <select name="class" required>
        <?php for ($i = 6; $i <= 10; $i++) echo "<option value='$i'>Class $i</option>"; ?>
      </select>

      <label>Subject:</label>
      <select name="subject" required>
        <option value="Math">Math</option>
        <option value="Science">Science</option>
        <option value="English">English</option>
        <option value="Social">Social</option>
        <option value="Telugu">Telugu</option>
        <option value="Hindi">Hindi</option>
        <option value="Computer">Computer</option>
      </select>

      <label>Teacher Name:</label>
      <input type="text" name="teacher_name" required>

      <input type="submit" value="Assign Teacher">
    </form>
  </div>

</body>
</html>

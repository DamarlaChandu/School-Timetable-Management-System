<?php
// Direct Database Connection (Replace with your actual DB credentials)
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
  <title>Add Student</title>
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

    .success {
      text-align: center;
      color: green;
      margin-top: 1rem;
    }
  </style>
</head>
<body>

  <header>
    <h1>👨‍🎓 Add Student</h1>
  </header>

  <div class="container">
    <h2>Register a New Student</h2>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $name = $_POST['name'];
      $class = $_POST['class'];

      $sql = "INSERT INTO students (name, class) VALUES ('$name', $class)";
      if ($conn->query($sql) === TRUE) {
        echo "<p class='success'>Student added successfully!</p>";
      } else {
        echo "<p class='success'>Error: " . $conn->error . "</p>";
      }
    }
    ?>

    <form method="POST" action="">
      <label>Student Name:</label>
      <input type="text" name="name" required>

      <label>Select Class:</label>
      <select name="class" required>
        <option value="">--Select Class--</option>
        <?php for ($i = 6; $i <= 10; $i++) echo "<option value='$i'>Class $i</option>"; ?>
      </select>

      <input type="submit" value="Add Student">
    </form>
  </div>

</body>
</html>

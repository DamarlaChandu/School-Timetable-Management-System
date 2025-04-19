<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "school_timetable";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$class = $_GET['class'];
$sql = "SELECT id, name FROM subjects WHERE class = $class";
$result = $conn->query($sql);

$subjects = [];
while ($row = $result->fetch_assoc()) {
  $subjects[] = $row;
}

header('Content-Type: application/json');
echo json_encode($subjects);

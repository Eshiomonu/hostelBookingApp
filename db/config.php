<?php
$host = 'localhost';
$db = 'hostel_db';
$user = 'root';
$pass = ''; // use your actual MySQL password

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

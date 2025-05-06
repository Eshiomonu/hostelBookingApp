<?php
include '../db/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $fullname = $_POST['fullname'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $department = $_POST['department'];
  $level = $_POST['level'];

  $stmt = $conn->prepare("INSERT INTO applications (fullname, email, phone, department, level) VALUES (?, ?, ?, ?, ?)");
  $stmt->bind_param("sssss", $fullname, $email, $phone, $department, $level);

  if ($stmt->execute()) {
    header("Location: ../success.html");
  } else {
    echo "Error: " . $stmt->error;
  }

  $stmt->close();
  $conn->close();
} else {
  echo "Invalid Request";
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Setup mailer
$mail = new PHPMailer(true);

try {
  $mail->isSMTP();
  $mail->Host = 'smtp.example.com'; // Your SMTP server
  $mail->SMTPAuth = true;
  $mail->Username = 'you@example.com'; // Your email
  $mail->Password = 'your_password';  // Your password
  $mail->SMTPSecure = 'tls';
  $mail->Port = 587;

  // Notify user
  $mail->setFrom('you@example.com', 'Hostel Management');
  $mail->addAddress($email, $fullname);
  $mail->Subject = 'Hostel Registration Confirmation';
  $mail->Body = "Hi $fullname,\n\nThank you for registering. Your application has been received.";

  $mail->send();

  // Notify admin
  $mail->clearAddresses();
  $mail->addAddress('admin@example.com'); // Admin email
  $mail->Subject = 'New Hostel Registration';
  $mail->Body = "New user registered:\n\nName: $fullname\nEmail: $email\nPhone: $phone\nDepartment: $department\nLevel: $level";
  $mail->send();
} catch (Exception $e) {
  error_log("Email Error: {$mail->ErrorInfo}");
}

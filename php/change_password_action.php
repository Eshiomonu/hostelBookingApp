<?php
session_start();
include '../db/config.php';

if (!isset($_SESSION['admin_logged_in'])) {
  header("Location: ../admin_login.html");
  exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $current = $_POST['current_password'];
  $new = $_POST['new_password'];
  $confirm = $_POST['confirm_password'];

  if ($new !== $confirm) {
    exit("New passwords do not match.");
  }

  $stmt = $conn->prepare("SELECT id, password FROM admins WHERE username = ?");
  $username = 'admin'; // Or fetch dynamically if multiple admins
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $stmt->store_result();

  if ($stmt->num_rows > 0) {
    $stmt->bind_result($admin_id, $hashed);
    $stmt->fetch();

    if (password_verify($current, $hashed)) {
      $new_hashed = password_hash($new, PASSWORD_DEFAULT);

      $update = $conn->prepare("UPDATE admins SET password = ? WHERE id = ?");
      $update->bind_param("si", $new_hashed, $admin_id);

      if ($update->execute()) {
        echo "Password changed successfully. <a href='../admin.php'>Back to Dashboard</a>";
      } else {
        echo "Failed to update password.";
      }

      $update->close();
    } else {
      echo "Current password is incorrect.";
    }
  } else {
    echo "Admin not found.";
  }

  $stmt->close();
  $conn->close();
}

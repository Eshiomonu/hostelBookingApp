<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
  header("Location: admin_login.html");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Change Password</title>
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <div class="form-container">
    <h2>Change Admin Password</h2>
    <form action="php/change_password_action.php" method="POST">
      <input type="password" name="current_password" placeholder="Current Password" required>
      <input type="password" name="new_password" placeholder="New Password" required>
      <input type="password" name="confirm_password" placeholder="Confirm New Password" required>
      <button type="submit">Change Password</button>
    </form>
    <p><a href="admin.php">Back to Dashboard</a></p>
  </div>
</body>

</html>
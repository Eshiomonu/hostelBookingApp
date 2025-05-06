<?php
include 'db/config.php';

// Fetch all applications
$sql = "SELECT * FROM applications ORDER BY created_at DESC";
$result = $conn->query($sql);
?>
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
  <title>Admin Dashboard - Hostel App</title>
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <div class="form-container">
    <h2>Admin Dashboard</h2>
    <p>Total Applications: <?php echo $result->num_rows; ?></p>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Full Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Department</th>
          <th>Level</th>
          <th>Applied On</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            echo "<tr>
              <td>{$row['id']}</td>
              <td>{$row['fullname']}</td>
              <td>{$row['email']}</td>
              <td>{$row['phone']}</td>
              <td>{$row['department']}</td>
              <td>{$row['level']}</td>
              <td>{$row['created_at']}</td>
            </tr>";
          }
        } else {
          echo "<tr><td colspan='7'>No applications found.</td></tr>";
        }
        ?>
      </tbody>
    </table>
    <p><a href="change_password.php" style="color:green;">Change Password</a></p>

    <p><a href="php/logout.php" style="color:red;">Logout</a></p>

  </div>
</body>

</html>
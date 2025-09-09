<?php
session_start();
if (!isset($_SESSION["admin"])) {
  header("Location: login.php");
  exit;
}
include("../db.php");

$result = mysqli_query($conn, "SELECT r.id, r.name, r.email, e.title AS event_name, r.registered_at 
                               FROM registrations r 
                               JOIN events e ON r.event_id = e.id 
                               ORDER BY r.id DESC");
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>View Registrations</title>
  <style>
    body {
  font-family: Arial, sans-serif;
  background: #201B3A; /* Dark Purple */
  padding: 30px;
}

h2 {
  text-align: center;
  margin-bottom: 20px;
  color: #fdfafaff; /* Deep Brown */
}

table {
  width: 100%;
  border-collapse: collapse;
  background: white;
  box-shadow: 0 0 10px rgba(0,0,0,0.15);
  border-radius: 6px;
  overflow: hidden;
}

th, td {
  padding: 12px;
  text-align: left;
  border-bottom: 1px solid #ddd;
}

th {
  background-color: #4364F7; /* Blue */
  color: white;
}

tr:nth-child(even) {
  background-color: #f2f2f2;
}

tr:hover {
  background-color: #F71C1C22; /* Soft Bright Red tint */
}

.back-btn {
  display: inline-block;
  margin-top: 20px;
  text-decoration: none;
  background: #F71C1C; /* Bright Red */
  color: white;
  padding: 10px 15px;
  border-radius: 6px;
  font-weight: bold;
  transition: background 0.3s;
}

.back-btn:hover {
  background: #083D1F; /* Dark Green hover */
}

  </style>
</head>
<body>

  <h2>All Event Registrations</h2>

  <table>
    <tr>
      <th>ID</th>
      <th>User Name</th>
      <th>Email</th>
      <th>Event</th>
      <th>Registered At</th>
    </tr>
    <?php while($row = mysqli_fetch_assoc($result)): ?>
      <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo htmlspecialchars($row['name']); ?></td>
        <td><?php echo htmlspecialchars($row['email']); ?></td>
        <td><?php echo htmlspecialchars($row['event_name']); ?></td>
        <td><?php echo $row['registered_at']; ?></td>
      </tr>
    <?php endwhile; ?>
  </table>

  <a href="dashboard.php" class="back-btn">← Back to Dashboard</a>

</body>
</html>

<?php
session_start();
if (!isset($_SESSION["admin"])) {
  header("Location: login.php");
  exit;
}
include("../db.php");

// Handle Delete
if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  mysqli_query($conn, "DELETE FROM events WHERE id = $id");
  echo "<script>alert('Event deleted successfully'); window.location='dashboard.php';</script>";
  exit;
}

// Handle Edit mode
$editMode = false;
$editData = [];
if (isset($_GET['edit'])) {
  $editMode = true;
  $editId = $_GET['edit'];
  $resultEdit = mysqli_query($conn, "SELECT * FROM events WHERE id = $editId");
  $editData = mysqli_fetch_assoc($resultEdit);
}

// Handle Create / Update
$success = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $title = $_POST["title"];
  $description = $_POST["description"];
  $event_date = $_POST["event_date"];
  $event_time = $_POST["event_time"];
  $location = $_POST["location"];
  $poster = "";

  // Upload file if available
  if (!empty($_FILES['poster']['name'])) {
    $poster_name = basename($_FILES['poster']['name']);
    $target_path = "../uploads/" . $poster_name;
    if (move_uploaded_file($_FILES['poster']['tmp_name'], $target_path)) {
      $poster = $poster_name;
    }
  }

  // Update or Insert
  if (!empty($_POST['event_id'])) {
    $id = $_POST['event_id'];
    $query = "UPDATE events SET title='$title', description='$description', event_date='$event_date', event_time='$event_time', location='$location'";
    if ($poster != "") {
      $query .= ", poster='$poster'";
    }
    $query .= " WHERE id=$id";
    mysqli_query($conn, $query);
    $success = "Event updated successfully!";
  } else {
    $query = "INSERT INTO events (title, description, event_date, event_time, location, poster)
              VALUES ('$title', '$description', '$event_date', '$event_time', '$location', '$poster')";
    mysqli_query($conn, $query);
    $success = "Event created successfully!";
  }

  header("Location: dashboard.php");
  exit;
}

$result = mysqli_query($conn, "SELECT * FROM events ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
   body {
  margin: 0;
  font-family: 'Segoe UI', sans-serif;
  background: #201B3A; /* Dark Purple background */
}

.navbar {
  background-color: #083D1F; /* Dark Green */
  padding: 15px 25px;
  color: white;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.navbar h1 {
  font-size: 20px;
  margin: 0;
}

.navbar a {
  color: white;
  text-decoration: none;
  padding: 8px 15px;
  border-radius: 6px;
  font-weight: bold;
}

.navbar .logout {
  background-color: #F71C1C; /* Bright Red */
}

.navbar .view {
  background-color: #4364F7; /* Blue */
  margin-right: 10px;
}

.container {
  max-width: 900px;
  margin: 30px auto;
  background: white;
  padding: 30px;
  border-radius: 10px;
  box-shadow: 0 0 15px rgba(0,0,0,0.15);
}

h2 {
  text-align: center;
  color: #230D0D; /* Deep Brown */
  margin-bottom: 25px;
}

form input, form textarea {
  width: 100%;
  padding: 12px;
  margin-top: 8px;
  border-radius: 6px;
  border: 1px solid #ccc;
  margin-bottom: 15px;
  font-size: 15px;
}

button {
  background-color: #4364F7; /* Blue */
  color: white;
  padding: 12px 20px;
  border: none;
  border-radius: 6px;
  font-weight: bold;
  cursor: pointer;
  transition: background-color 0.3s;
}

button:hover {
  background-color: #083D1F; /* Dark Green hover */
}

.success {
  background-color: #d4edda;
  padding: 12px;
  border: 1px solid #c3e6cb;
  color: #155724;
  border-radius: 6px;
  margin-bottom: 15px;
  text-align: center;
}

table {
  width: 100%;
  margin-top: 25px;
  border-collapse: collapse;
}

th, td {
  padding: 12px;
  border-bottom: 1px solid #ddd;
  text-align: left;
}

th {
  background-color: #f8f9fa;
}

.btn {
  padding: 6px 12px;
  border-radius: 4px;
  text-decoration: none;
  color: white;
  font-weight: bold;
  margin-right: 5px;
}

.delete-btn {
  background-color: #F71C1C; /* Bright Red */
}

.edit-btn {
  background-color: #230D0D; /* Deep Brown */
  color: white;
}

  </style>
</head>
<body>

<div class="navbar">
  <h1><i class="fas fa-user-cog"></i> Admin Dashboard</h1>
  <div class="nav-links">
    <a href="view_registrations.php" class="view"><i class="fas fa-eye"></i> View Registrations</a>
    <a href="logout.php" class="logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
  </div>
</div>

<div class="container">
  <h2><i class="fas fa-calendar-plus"></i> <?php echo $editMode ? "Edit Event" : "Create New Event"; ?></h2>

  <?php if (!empty($success)): ?>
    <div class="success"><i class="fas fa-check-circle"></i> <?php echo $success; ?></div>
  <?php endif; ?>

  <form method="POST" enctype="multipart/form-data">
    <?php if ($editMode): ?>
      <input type="hidden" name="event_id" value="<?php echo $editData['id']; ?>">
    <?php endif; ?>
    <input type="text" name="title" placeholder="Event Title" required value="<?php echo $editMode ? htmlspecialchars($editData['title']) : ''; ?>">
    <textarea name="description" placeholder="Event Description" required><?php echo $editMode ? htmlspecialchars($editData['description']) : ''; ?></textarea>
    <input type="date" name="event_date" required value="<?php echo $editMode ? $editData['event_date'] : ''; ?>">
    <input type="time" name="event_time" required value="<?php echo $editMode ? $editData['event_time'] : ''; ?>">
    <input type="text" name="location" placeholder="Location" required value="<?php echo $editMode ? htmlspecialchars($editData['location']) : ''; ?>">
    <input type="file" name="poster" accept="image/*">
    <button type="submit"><i class="fas fa-save"></i> <?php echo $editMode ? "Update Event" : "Create Event"; ?></button>
  </form>

  <h2><i class="fas fa-list"></i> All Events</h2>
  <table>
    <tr>
      <th>Title</th>
      <th>Date</th>
      <th>Time</th>
      <th>Location</th>
      <th>Action</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
      <tr>
        <td><?php echo htmlspecialchars($row['title']); ?></td>
        <td><?php echo $row['event_date']; ?></td>
        <td><?php echo $row['event_time']; ?></td>
        <td><?php echo $row['location']; ?></td>
        <td>
          <a class="btn delete-btn" href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Delete this event?')">Delete</a>
          <a class="btn edit-btn" href="?edit=<?php echo $row['id']; ?>">Edit</a>
        </td>
      </tr>
    <?php endwhile; ?>
  </table>
</div>

</body>
</html>

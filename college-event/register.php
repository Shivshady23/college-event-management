<?php
include("db.php");

$event_id = isset($_GET['event_id']) ? $_GET['event_id'] : null;
$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $event_id = $_POST['event_id'];

  $insert = mysqli_query($conn, "INSERT INTO registrations (name, email, event_id) VALUES ('$name', '$email', '$event_id')");

  if ($insert) {
    $success = true;
    header("Location: index.php?registered=1");
    exit;
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Event Registration</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    body {
  font-family: 'Segoe UI', sans-serif;
  background: linear-gradient(135deg, #1E0C0C, #1E193D);
  margin: 0;
  padding: 0;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  color: #fff;
}

.form-container {
  background: rgba(30, 12, 12, 0.85);
  backdrop-filter: blur(10px);
  padding: 30px 40px;
  border-radius: 12px;
  box-shadow: 0 0 25px rgba(255, 30, 30, 0.5),
              0 0 15px rgba(67, 96, 238, 0.3);
  width: 100%;
  max-width: 500px;
  animation: fadeIn 0.6s ease-in;
  border: 2px solid #FF1E1E;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}

h2 {
  text-align: center;
  margin-bottom: 25px;
  color: #FF1E1E;
  text-shadow: 0 0 10px rgba(255,30,30,0.7);
}

label {
  font-weight: bold;
  display: block;
  margin-top: 15px;
  color: #4360EE;
}

input[type="text"], input[type="email"] {
  width: 100%;
  padding: 10px 12px;
  margin-top: 5px;
  border: 1px solid #4360EE;
  border-radius: 6px;
  font-size: 16px;
  background-color: #0A4026;
  color: #fff;
  transition: all 0.3s;
}

input:focus {
  border-color: #FF1E1E;
  box-shadow: 0 0 8px rgba(255, 30, 30, 0.7);
  outline: none;
}

button {
  margin-top: 20px;
  width: 100%;
  padding: 12px;
  background: linear-gradient(135deg, #FF1E1E, #4360EE);
  color: white;
  font-weight: bold;
  font-size: 16px;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  transition: transform 0.2s, box-shadow 0.3s;
}

button:hover {
  transform: translateY(-2px);
  box-shadow: 0 0 15px rgba(255, 30, 30, 0.8),
              0 0 10px rgba(67, 96, 238, 0.7);
}

.success {
  background-color: rgba(10, 64, 38, 0.9);
  color: #28a745;
  padding: 15px;
  border-radius: 6px;
  text-align: center;
  margin-bottom: 15px;
  border: 1px solid #28a745;
}

.back-link {
  display: block;
  text-align: center;
  margin-top: 20px;
  color: #4360EE;
  text-decoration: none;
  font-weight: bold;
}

.back-link:hover {
  text-decoration: underline;
  color: #FF1E1E;
}

  </style>
</head>
<body>

  <div class="form-container">
    <h2><i class="fas fa-edit"></i> Register for Event</h2>

    <?php if ($success): ?>
      <div class="success"><i class="fas fa-check-circle"></i> Registration successful!</div>

    <?php endif; ?>

    <form method="POST">
      <input type="hidden" name="event_id" value="<?php echo htmlspecialchars($event_id); ?>" />

      <label for="name"><i class="fas fa-user"></i> Name:</label>
      <input type="text" name="name" id="name" required />

      <label for="email"><i class="fas fa-envelope"></i> Email:</label>
      <input type="email" name="email" id="email" required />

      <button type="submit"><i class="fas fa-paper-plane"></i> Submit</button>
    </form>

    <a href="index.php" class="back-link"><i class="fas fa-arrow-left"></i> Back to Events</a>
  </div>

</body>
</html>

<?php
session_start();
include("db.php");

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST["email"];
  $password = $_POST["password"];

  $query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
  $result = mysqli_query($conn, $query);

  if (mysqli_num_rows($result) == 1) {
    $_SESSION["user"] = $email;
    header("Location: ../college-event");
    exit;
  } else {
    $error = "Invalid login credentials!";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <style>
    * {
  box-sizing: border-box;
}

body {
  margin: 0;
  font-family: 'Segoe UI', sans-serif;
  background: linear-gradient(135deg, #1E0C0C, #1E193D);
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  color: #fff;
}

.form-container {
  background: rgba(30, 12, 12, 0.95);
  padding: 40px 30px;
  border-radius: 16px;
  box-shadow: 0 0 25px rgba(255, 30, 30, 0.6), 0 0 15px rgba(67, 96, 238, 0.4);
  width: 100%;
  max-width: 400px;
  animation: fadeIn 0.6s ease-in-out;
  border: 2px solid #FF1E1E;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

h2 {
  text-align: center;
  color: #FF1E1E;
  margin-bottom: 25px;
  text-shadow: 0 0 8px rgba(255, 30, 30, 0.8);
}

input[type="email"],
input[type="password"] {
  width: 100%;
  padding: 12px 15px;
  font-size: 15px;
  border: 1px solid #4360EE;
  border-radius: 8px;
  margin-bottom: 20px;
  background-color: #0A4026;
  color: #fff;
  transition: border-color 0.3s, box-shadow 0.3s;
}

input:focus {
  border-color: #FF1E1E;
  outline: none;
  box-shadow: 0 0 8px rgba(255, 30, 30, 0.6);
}

button {
  width: 100%;
  padding: 12px;
  background-color: #4360EE;
  color: white;
  font-size: 16px;
  font-weight: bold;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  transition: all 0.3s;
}

button:hover {
  background-color: #FF1E1E;
  box-shadow: 0 0 12px rgba(255, 30, 30, 0.8);
}

.error {
  background-color: rgba(255, 30, 30, 0.2);
  color: #FF1E1E;
  padding: 12px;
  margin-bottom: 15px;
  border-radius: 8px;
  text-align: center;
  border: 1px solid #FF1E1E;
}

p {
  text-align: center;
  margin-top: 15px;
  color: #ccc;
}

a {
  color: #4360EE;
  text-decoration: none;
  transition: color 0.3s;
}

a:hover {
  color: #FF1E1E;
  text-decoration: underline;
}

@media (max-width: 480px) {
  .form-container {
    padding: 30px 20px;
  }

  h2 {
    font-size: 22px;
  }
}

  </style>
</head>
<body>
  <div class="form-container">
    <h2>User Login</h2>
    <?php if (!empty($error)) echo "<div class='error'>$error</div>"; ?>
    <form method="POST">
      <input type="email" name="email" placeholder="Email" required />
      <input type="password" name="password" placeholder="Password" required />
      <button type="submit">Login</button>
      <p>Don't have an account? <a href="user_register.php">Register</a></p>
    </form>
  </div>
</body>
</html>
 
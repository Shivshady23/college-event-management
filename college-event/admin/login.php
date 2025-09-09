<?php
session_start();
include("../db.php");

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["username"];
  $password = $_POST["password"];

  if ($username === "admin" && $password === "admin123") {
    $_SESSION["admin"] = true;
    header("Location: dashboard.php");
    exit;
  } else {
    $error = "Invalid username or password!";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Admin Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

  <style>
    * {
  box-sizing: border-box;
}

body {
  margin: 0;
  font-family: 'Segoe UI', sans-serif;
  background: linear-gradient(135deg, #4364F7, #201B3A); /* Blue → Dark Purple */
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}

.login-box {
  background: #fff;
  padding: 40px 30px;
  border-radius: 16px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.3);
  width: 100%;
  max-width: 400px;
  animation: fadeIn 0.6s ease-in-out;
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
  color: #230D0D; /* Deep Brown */
  margin-bottom: 25px;
}

.form-group {
  margin-bottom: 20px;
}

label {
  display: block;
  margin-bottom: 6px;
  font-size: 15px;
  color: #083D1F; /* Dark Green */
}

input[type="text"],
input[type="password"] {
  width: 100%;
  padding: 12px 15px;
  font-size: 15px;
  border: 1px solid #ccc;
  border-radius: 8px;
  transition: border-color 0.3s;
}

input:focus {
  border-color: #4364F7; /* Blue */
  outline: none;
}

button {
  width: 100%;
  padding: 12px;
  background-color: #F71C1C; /* Bright Red */
  color: white;
  font-size: 16px;
  font-weight: bold;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  transition: background 0.3s;
}

button:hover {
  background-color: #083D1F; /* Dark Green hover */
}

.error {
  background-color: #F8D7DA;
  color: #F71C1C; /* Bright Red for text */
  padding: 12px;
  margin-bottom: 20px;
  border-radius: 8px;
  text-align: center;
  border: 1px solid #F5C6CB;
}

@media (max-width: 480px) {
  .login-box {
    padding: 30px 20px;
  }

  h2 {
    font-size: 22px;
  }
}

  </style>
</head>
<body>

  <div class="login-box" role="form" aria-labelledby="adminLoginHeading">
    <h2 id="adminLoginHeading"><i class="fas fa-user-shield"></i> Admin Login</h2>

    <?php if (!empty($error)): ?>
      <div class="error"><i class="fas fa-exclamation-circle"></i> <?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST" autocomplete="off">
      <div class="form-group">
        <label for="username"><i class="fas fa-user"></i> Username</label>
        <input type="text" id="username" name="username" placeholder="Enter username" required />
      </div>

      <div class="form-group">
        <label for="password"><i class="fas fa-lock"></i> Password</label>
        <input type="password" id="password" name="password" placeholder="Enter password" required />
      </div>

      <button type="submit"><i class="fas fa-sign-in-alt"></i> Login</button>
    </form>
  </div>

</body>
</html>

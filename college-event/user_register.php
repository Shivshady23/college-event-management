<?php
include("db.php");

$success = false;
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST["name"];
  $email = $_POST["email"];
  $password = $_POST["password"];

  $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
  if (mysqli_num_rows($check) > 0) {
    $error = "Email already exists!";
  } else {
    $query = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
    if (mysqli_query($conn, $query)) {
      $success = true;
    } else {
      $error = "Registration failed!";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>User Registration</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(135deg, #083D1F, #201B3A);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .form-container {
      background: #fff;
      padding: 40px 30px;
      border-radius: 16px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.2);
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
      color: #333;
      margin-bottom: 25px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    label {
      display: block;
      margin-bottom: 6px;
      font-size: 15px;
      color: #555;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 12px 15px;
      font-size: 15px;
      border: 1px solid #ccc;
      border-radius: 8px;
      transition: border-color 0.3s;
    }

    input:focus {
      border-color: #764ba2;
      outline: none;
    }

    button {
      width: 100%;
      padding: 12px;
      background-color:  #083D1F;
      color: white;
      font-size: 16px;
      font-weight: bold;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      transition: background 0.3s;
    }

    button:hover {
      background-color: #0056b3;
    }

    .success, .error {
      padding: 12px;
      margin-bottom: 20px;
      border-radius: 8px;
      text-align: center;
      font-weight: bold;
    }

    .success {
      background-color: #d4edda;
      color: #155724;
      border: 1px solid #c3e6cb;
    }

    .error {
      background-color: #f8d7da;
      color: #721c24;
      border: 1px solid #f5c6cb;
    }

    .extra-link {
      text-align: center;
      font-size: 14px;
    }

    .extra-link a {
      color: #007bff;
      text-decoration: none;
    }

    .extra-link a:hover {
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

  <div class="form-container" role="form" aria-labelledby="registerHeading">
    <h2 id="registerHeading"><i class="fas fa-user-plus"></i> Register</h2>

    <?php if ($success): ?>
      <div class="success"><i class="fas fa-check-circle"></i> Registration successful! <a href="user_login.php">Login now</a></div>
    <?php elseif (!empty($error)): ?>
      <div class="error"><i class="fas fa-exclamation-circle"></i> <?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST">
      <div class="form-group">
        <label for="name"><i class="fas fa-user"></i> Full Name</label>
        <input type="text" name="name" id="name" placeholder="Enter your name" required />
      </div>
      <div class="form-group">
        <label for="email"><i class="fas fa-envelope"></i> Email</label>
        <input type="email" name="email" id="email" placeholder="Enter your email" required />
      </div>
      <div class="form-group">
        <label for="password"><i class="fas fa-lock"></i> Password</label>
        <input type="password" name="password" id="password" placeholder="Enter your password" required />
      </div>
      <button type="submit"><i class="fas fa-user-plus"></i> Register</button>
      <div class="extra-link">
        Already have an account? <a href="user_login.php">Login here</a>
      </div>
    </form>
  </div>

</body>
</html>

<?php
include("db.php");

$search = "";
if (isset($_GET['search'])) {
  $search = mysqli_real_escape_string($conn, $_GET['search']);
  $query = "SELECT * FROM events 
            WHERE title LIKE '%$search%' 
               OR location LIKE '%$search%' 
               OR event_date LIKE '%$search%' 
            ORDER BY id DESC";
} else {
  $query = "SELECT * FROM events ORDER BY id DESC";
}

$result = mysqli_query($conn, $query);
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>College Event Portal</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

  <style>
   body {
  font-family: 'Segoe UI', sans-serif;
  background: linear-gradient(135deg, #1E0C0C, #1E193D);
  margin: 0;
  padding: 20px;
  animation: bgMove 8s infinite alternate;
  color: #fff;
}

@keyframes bgMove {
  0% { background-position: 0% 50%; }
  100% { background-position: 100% 50%; }
}

.container {
  max-width: 1100px;
  margin: auto;
  background: rgba(30, 12, 12, 0.9);
  padding: 30px;
  border-radius: 12px;
  box-shadow: 0 0 20px rgba(255, 30, 30, 0.5),
              0 0 10px rgba(67, 96, 238, 0.4);
  border: 2px solid #FF1E1E;
}

h2 {
  text-align: center;
  margin-bottom: 25px;
  color: #FF1E1E;
  text-shadow: 0 0 10px rgba(255, 30, 30, 0.8);
}

.search-bar {
  text-align: center;
  margin-bottom: 30px;
}

.search-bar input[type="text"] {
  padding: 10px;
  width: 300px;
  border-radius: 6px;
  border: 1px solid #4360EE;
  font-size: 16px;
  background-color: #0A4026;
  color: #fff;
}

.search-bar button {
  padding: 10px 15px;
  background-color: #FF1E1E;
  color: white;
  border: none;
  border-radius: 6px;
  margin-left: 8px;
  font-weight: bold;
  cursor: pointer;
  transition: all 0.3s;
}

.search-bar button:hover {
  background-color: #4360EE;
  box-shadow: 0 0 12px rgba(67, 96, 238, 0.7);
}

.card-grid {
  display: flex;
  flex-direction: column;
  gap: 25px;
  align-items: center;
}

.flip-card {
  background-color: transparent;
  width: 300px;
  height: 360px;
  perspective: 1000px;
  cursor: pointer;
  margin-bottom: 30px;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.flip-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 20px rgba(255, 30, 30, 0.4);
}

.flip-card-inner {
  position: relative;
  width: 100%;
  height: 100%;
  text-align: center;
  transition: transform 0.8s ease;
  transform-style: preserve-3d;
}

.flip-card.flipped .flip-card-inner {
  transform: rotateY(180deg);
}

.flip-card-front, .flip-card-back {
  position: absolute;
  width: 100%;
  height: 100%;
  padding: 20px;
  backface-visibility: hidden;
  border-radius: 10px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.4);
  overflow: hidden;
}

.flip-card-front {
  background-color: #0A4026;
  color: #fff;
  border: 2px solid #4360EE;
}

.flip-card-front img {
  width: 100%;
  height: 150px;
  object-fit: cover;
  border-radius: 8px;
  margin-bottom: 10px;
}

.flip-card-back {
  background-color: #1E193D;
  color: #fff;
  transform: rotateY(180deg);
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  border: 2px solid #FF1E1E;
}

.flip-card-back p {
  font-size: 14px;
  margin-top: 0;
}

.register-btn {
  display: inline-block;
  margin-top: 15px;
  background-color: #4360EE;
  color: white;
  padding: 10px 16px;
  border-radius: 6px;
  text-decoration: none;
  font-weight: bold;
  transition: all 0.3s;
}

.register-btn:hover {
  background-color: #FF1E1E;
  box-shadow: 0 0 12px rgba(255, 30, 30, 0.7);
}

.no-event {
  text-align: center;
  font-size: 18px;
  color: #bbb;
  margin-top: 40px;
}

@media (max-width: 600px) {
  .search-bar input[type="text"] {
    width: 90%;
  }

  .flip-card {
    width: 100%;
  }

  .container {
    padding: 20px;
  }
}

.tooltip {
  position: relative;
  display: inline-block;
}

.tooltip .tooltiptext {
  visibility: hidden;
  width: 240px;
  background-color: #1E193D;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 8px;
  position: absolute;
  bottom: 125%;
  left: 50%;
  margin-left: -120px;
  opacity: 0;
  transition: opacity 0.3s;
  z-index: 999;
  border: 1px solid #FF1E1E;
}

.tooltip:hover .tooltiptext {
  visibility: visible;
  opacity: 1;
}

.popup-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0,0,0,0.7);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
}

.popup-box {
  background-color: #1E0C0C;
  padding: 30px;
  border-radius: 12px;
  box-shadow: 0 0 20px rgba(255, 30, 30, 0.5);
  max-width: 400px;
  text-align: center;
  animation: fadeIn 0.5s ease;
  border: 2px solid #4360EE;
}

.popup-box h2 {
  margin-top: 0;
  color: #FF1E1E;
  text-shadow: 0 0 10px rgba(255,30,30,0.7);
}

.popup-box button {
  background-color: #4360EE;
  color: white;
  padding: 10px 18px;
  border: none;
  border-radius: 6px;
  margin-top: 15px;
  cursor: pointer;
  font-weight: bold;
  transition: all 0.3s;
}

.popup-box button:hover {
  background-color: #FF1E1E;
  box-shadow: 0 0 12px rgba(255, 30, 30, 0.7);
}

@keyframes fadeIn {
  from { transform: scale(0.95); opacity: 0; }
  to { transform: scale(1); opacity: 1; }
}

  </style>
</head>
<body>

  <!-- Welcome Popup -->
  <div id="welcomePopup" class="popup-overlay">
    <div class="popup-box">
      <h2>🎉 Welcome!</h2>
      <p>By getting registered in each event, you will earn <strong>20 points</strong>.<br>
      With <strong>100 points</strong>, you become eligible for the <span style="color:#e83e8c;">Disco Night</span>! 💃🕺</p>
      <button onclick="closePopup()">Got it!</button>
    </div>
  </div>

  <!-- Registration Success Popup -->
  <?php if (isset($_GET['registered']) && $_GET['registered'] == '1'): ?>
    <div id="registeredPopup" class="popup-overlay">
      <div class="popup-box">
        <h2>✅ Registered!</h2>
        <p>🎉 You’ve successfully registered and earned <strong>20 points</strong><br> Get your event pass from the desk</p>
        <button onclick="document.getElementById('registeredPopup').style.display='none'">OK</button>
      </div>
    </div>
  <?php endif; ?>

  <div class="container">
    <h2><i class="fas fa-calendar-alt"></i> Browse Upcoming Events</h2>

    <div class="search-bar">
      <form method="GET">
        <input type="text" name="search" placeholder="Search by title, location or date" value="<?php echo htmlspecialchars($search); ?>" />
        <button type="submit"><i class="fas fa-search"></i> Search</button>
      </form>
    </div>

    <?php if (mysqli_num_rows($result) > 0): ?>
      <div class="card-grid">
        <?php while($row = mysqli_fetch_assoc($result)): ?>
          <div class="flip-card">
            <div class="flip-card-inner">
              <div class="flip-card-front">
                <?php
                  $posterPath = !empty($row['poster']) ? "uploads/" . htmlspecialchars($row['poster']) : "uploads/default.jpg";
                ?>
                <img src="<?php echo $posterPath; ?>" alt="Event Poster">
                <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                <p><strong>Date:</strong> <?php echo $row['event_date']; ?></p>
                <p><strong>Time:</strong> <?php echo $row['event_time']; ?></p>
                <p><strong>Location:</strong> <?php echo htmlspecialchars($row['location']); ?></p>
              </div>
              <div class="flip-card-back">
                <div>
                  <p><?php echo htmlspecialchars($row['description']); ?></p>
                </div>
                <a class="register-btn tooltip" href="register.php?event_id=<?php echo $row['id']; ?>">
                  <i class="fas fa-clipboard-check"></i> Register
                  <span class="tooltiptext">You will get 20 points by getting registered</span>
                </a>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      </div>
    <?php else: ?>
      <p class="no-event"><i class="fas fa-info-circle"></i> No events found.</p>
    <?php endif; ?>
  </div>

  <script>
    document.querySelectorAll('.flip-card').forEach(card => {
      card.addEventListener('click', function () {
        this.classList.toggle('flipped');
      });
    });

    function closePopup() {
      document.getElementById("welcomePopup").style.display = "none";
    }

    window.addEventListener('load', function () {
      setTimeout(function () {
        document.getElementById("welcomePopup").style.display = "flex";
      }, 500);

      const regPopup = document.getElementById("registeredPopup");
      if (regPopup) {
        setTimeout(() => {
          regPopup.style.display = "none";
        }, 4000);
      }
    });
  </script>

</body>
</html>
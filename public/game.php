<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: /typegame/public/index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Typos!</title>
  <link href="https://fonts.googleapis.com/css2?family=VT323&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/navbar.css">
  <link rel="stylesheet" href="css/commandBar.css">
  <link rel="stylesheet" href="css/game.css">
</head>
<body>
  <div id="mainav">
      <div id="nav">
          <h1 id="title">Typos!</h1>
          <div class="buttonWrapper">
              <input type="button" id="opage" class="botaon" value="Play!" onclick="window.location.href='game.php';">
              <input type="button" class="botaon" value="Leagues" onclick="window.location.href='league.php';">
              <input type="button" class="botaon" value="Profile" onclick="window.location.href='profile.php';">
          </div>
      </div>
  </div>

  <div class="main">
    <div id="timer"></div>
    <div id="text-display"></div>
    <div id="stats"></div>
  </div>

    <div class="crt-overlay"></div>
    <div class="frame"></div>
  <script src="js/commandBar.js"></script>
  <script src="js/game.js"></script>
</body>
</html>
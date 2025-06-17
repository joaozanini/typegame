<?php
session_start();

if (isset($_SESSION['user_id'])) {
    echo "Usuário logado. ID: " . $_SESSION['user_id'];
} else {
    echo "Usuário não está logado.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Typos!</title>
  <link href="https://fonts.googleapis.com/css2?family=VT323&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/game.css">
</head>
<body>

  <div class="main">
    <div id="timer"></div>
    <div id="text-display"></div>
    <div id="stats"></div>
  </div>

    <div class="crt-overlay"></div>
    <div class="frame"></div>
  <script src="js/game.js"></script>
</body>
</html>
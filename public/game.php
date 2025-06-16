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
  <link rel="stylesheet" href="css/game.css">
</head>
<body>
    <h2>jogo</h2>
  <div id="text-display"></div>
  <div id="stats"></div>

  <script src="js/game.js"></script>
</body>
</html>
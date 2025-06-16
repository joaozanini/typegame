<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: /typegame/public/game.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Typos!</title>
    <link href="https://fonts.googleapis.com/css2?family=VT323&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="conteiner">
    <div class="main">

    <div class="titulo">
        <h1>Typos!</h1>
    </div>
    <div class="botao-wrapper">
        <a href="register.php" class="botao">Sign up</a>
        <a href="login.php" class="botao">Sign in</a>
    </div>

    <p>(Press "esc" to use the command bar, type :help, for adicional comands)</p>
    </div>
    </div>


    <div class="crt-overlay"></div>
    <div class="frame"></div>
</body>
</html>
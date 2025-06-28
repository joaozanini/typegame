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
    <title>Login - Typos!</title>
    <link href="https://fonts.googleapis.com/css2?family=VT323&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/commandBar.css">
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
<div class="main">
    <form id="form" method="post" action="../src/Controllers/LoginController.php">
        <div class="form-wrapper">
            <h1>Login</h1>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" name="email" id="email" class="form-content" spellcheck="false">
                <li class="erro"></li>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <div class="password-wrapper">
                    <input name="password" type="password" id="senha" class="form-content">
                    <input type="button" value="<o>" class="eye" id="show1">
                </div>
                <li class="erro"></li>
            </div>

            <div>
                <input type="button" class="botao" value="Back" onclick="window.history.back()">
                <button type="submit" class="botao" id="submit">Play!</button>
            </div>
        </div>
    </form>
    <div class="redirect">
        <p>Do not have a account yet? </p>
        <a href="register.php"> Click Here!</a>
    </div>
</div>

    <div class="crt-overlay"></div>
    <div class="frame"></div>

    <script src="js/commandBar.js"></script>
    <script src="js/loginValidation.js"></script>

</body>
</html>
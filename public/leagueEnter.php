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
    <title>Enter a League</title>
    <link href="https://fonts.googleapis.com/css2?family=VT323&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/leagueEnter.css">
</head>
<body>
    <div id="mainav">
        <div id="nav">
            <h1 id="title">Typos!</h1>
            <div class="buttonWrapper">
                <input type="button" class="botaon" value="Play!" onclick="window.location.href='game.php';">
                <input type="button" id="opage" class="botaon" value="Leagues" onclick="window.location.href='league.php';">
                <input type="button" class="botaon" value="Profile" onclick="window.location.href='profile.php';">
            </div>
        </div>
    </div>

    <div class="main">
    <form id="form" method="post" action="">
        <div class="form-wrapper">
            <h1 id="tl">Enter a league</h1>
            <div class="form-group">
                <label for="email">League name:</label>
                <input type="text" name="email" id="liga" class="form-content" spellcheck="false">
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
                <input type="button" class="botao" value="Back" onclick="window.location.href='league.php';">
                <button type="submit" class="botao" id="submit">Enter!</button>
            </div>
        </div>
    </form>
    </div>





    <div class="crt-overlay"></div>
    <div class="frame"></div>

    <script src="js/leagueEnter.js"></script>
</body>
</html>
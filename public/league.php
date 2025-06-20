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
    <title>Leagues!</title>
    <link href="https://fonts.googleapis.com/css2?family=VT323&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/league.css">
</head>
<body>
    <div id="mainav">
        <div id="nav">
            <h1>Typos!</h1>
            <div class="buttonWrapper">
                <input type="button" class="botao" value="Play!" onclick="window.location.href='game.php';">
                <input type="button" id="opage" class="botao" value="Leagues" onclick="window.location.href='league.php';">
                <input type="button" class="botao" value="Profile" onclick="window.location.href='profile.php';">
            </div>
        </div>
    </div>

    <div id="main">

        <form id="groupForm" method="POST" action="">
            <input type="hidden" name="grupo" id="grupoSelecionado">
        </form>
        <div id="cabecalho">
            <h1>Your leagues:</h1>
            <div class="custom-select" id="custom-select">
            <div class="select-selected">
                <span class="selected-text">Select a league</span>
                <span class="arrow">&#9662;</span>
            </div>
            <div class="select-items select-hide">
                <div data-value="league1">1</div>
                <div data-value="league2">2</div>
                <div data-value="league3">3</div>
            </div>
            </div>
            <div class="botaonWrapper">
                <input type="button" class="botao" value="Create">
                <input type="button" class="botao" value="Enter">
            </div>
        </div>


        <div id="userHistory">
            <section id="historyConteiner">
                <table class="historyTable">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Matches</th>
                            <th class="sort">Weekly score <span class="ordem">&#9662;</span></th>
                            <th class="sort">Total score <span class="ordem">&#9662;</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#1</td>
                            <td>2025-3-3</td>
                            <td>30</td>
                            <td>123</td>
                        </tr>
                        <tr>
                            <td>#2</td>
                            <td>2025-3-3</td>
                            <td>40</td>
                            <td>120</td>
                        </tr>
                    </tbody>
               </table>
            </section>
        </div>

    </div>





    <div class="crt-overlay"></div>
    <div class="frame"></div>
    <script src="js/league.js"></script>
</body>
</html>
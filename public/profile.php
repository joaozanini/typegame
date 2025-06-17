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
    <title>Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=VT323&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/profile.css">
</head>
<body>

    <div class="main">
        <div id="userInfo">
            <img src="img/placeholder.png" alt="">
            <h1 id="username">PLACEHOLDER</h1>
            <div class="buttonWrapper">
                <input type="button" class="botao" value="Logout">
                <input type="button" class="botao" value="Edit">
            </div>
        </div>

        <hr class="divider">

        <div id="userHistory">
            <h2>History:</h2>
            <section>
                <div class="historyUnit">
                    <div class="matchHeader">
                        <h3>Match #1</h3>
                        <h3>Date: 2025-3-3</h3>
                    </div>
                    <p>WPM: 100</p>
                    <p>Errors: </p>
                    <p>Accuracy: </p>
                    <p>Time: 30s</p>
                    <h4>Total score: 100</h4>
                </div>

                <div class="historyUnit">
                    <div class="matchHeader">
                        <h3>Match #1</h3>
                        <h3>Date: 2025-3-3</h3>
                    </div>
                    <p>WPM: 100</p>
                    <p>Errors: </p>
                    <p>Accuracy: </p>
                    <p>Time: 30s</p>
                    <h4>Total score: 100</h4>
                </div>


            </section>

        </div>
    </div>
    

    <div class="crt-overlay"></div>
    <div class="frame"></div>

</body>
</html>
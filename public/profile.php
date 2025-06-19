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
            <div id="userData">
                <h1 id="username">PLACEHOLDER</h1>
                <h2>Total score: 111111111111111</h2>
            </div>
            <div class="buttonWrapper">
                <input type="button" class="botao" value="Logout">
                <input type="button" class="botao" value="Edit">
            </div>
        </div>

        <hr class="divider">

        <div id="userHistory">
            <h2>History:</h2>
            <section id="historyConteiner">
                <table class="historyTable">
                    <thead>
                        <tr>
                            <th>Match</th>
                            <th>Date</th>
                            <th>WPM</th>
                            <th>Errors</th>
                            <th>Accuracy</th>
                            <th>Time</th>
                            <th>Score</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#1</td>
                            <td>2025-3-3</td>
                            <td>100</td>
                            <td>—</td>
                            <td>—</td>
                            <td>30s</td>
                            <td>100</td>
                        </tr>
                        <tr>
                            <td>#2</td>
                            <td>2025-3-3</td>
                            <td>100</td>
                            <td>—</td>
                            <td>—</td>
                            <td>30s</td>
                            <td>100</td>
                        </tr>
                        <tr>
                            <td>#3</td>
                            <td>2025-3-3</td>
                            <td>100</td>
                            <td>—</td>
                            <td>—</td>
                            <td>30s</td>
                            <td>100</td>
                        </tr>
                        <tr>
                            <td>#4</td>
                            <td>2025-3-3</td>
                            <td>100</td>
                            <td>—</td>
                            <td>—</td>
                            <td>30s</td>
                            <td>100</td>
                        </tr>
                        <tr>
                            <td>#5</td>
                            <td>2025-3-3</td>
                            <td>100</td>
                            <td>—</td>
                            <td>—</td>
                            <td>30s</td>
                            <td>100</td>
                        </tr>
                    </tbody>
                </table>
            </section>

        </div>
    </div>
    

    <div class="crt-overlay"></div>
    <div class="frame"></div>

</body>
</html>
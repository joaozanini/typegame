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
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/commandBar.css">
    <link rel="stylesheet" href="css/profile.css">
</head>
<body>
    <div id="mainav">
        <div id="nav">
            <h1 id="title">Typos!</h1>
            <div class="buttonWrapper">
                <input type="button" class="botaon" value="Play!" onclick="window.location.href='game.php';">
                <input type="button" class="botaon" value="Leagues" onclick="window.location.href='league.php';">
                <input type="button" id="opage" class="botaon" value="Profile" onclick="window.location.href='profile.php';">
            </div>
        </div>
    </div>

    <div class="main">
        <div id="userInfo">
            <img src="img/placeholder.png" alt="">
            <div id="userData">
                <h1 id="username"> 
                    <?php 
                    require_once '../src/Models/User.php';
                    $nickname = $_SESSION['username'];
                    echo $nickname;
                    ?>
                </h1>
                <h2>Total score: 
                    <?php 
                    require_once '../src/Models/User.php';
                    $id = $_SESSION['user_id'];
                    $pontos = getTotalPoints($id);
                    echo $pontos;
                    ?>
                </h2>
            </div>
            <div class="buttonConteiner">
                <input type="button" class="botao" value="Logout" onclick="confirmLogout()">
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
                            <th>WPM</th>
                            <th>Errors</th>
                            <th>Accuracy</th>
                            <th>Time</th>
                            <th>Score</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require_once __DIR__ . '/../src/Models/GameResult.php';

                        $userId = $_SESSION['user_id'];
                        $gameResults = findAllGameResultsByUserId($userId);

                        if (!empty($gameResults)) {
                            $matchNumber = 1;
                            foreach ($gameResults as $result) {
                                echo "<tr>";
                                echo "<td>#{$matchNumber}</td>";
                                echo "<td>{$result['wpm']}</td>";
                                echo "<td>{$result['error_count']}</td>";
                                echo "<td>{$result['accuracy']}%</td>";
                                echo "<td>{$result['total_time']}s</td>";
                                echo "<td>{$result['points']}</td>";
                                echo "</tr>";
                                $matchNumber++;
                            }
                        } else {
                            echo "<tr><td colspan='6'>No game history found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </section>

        </div>
    </div>
    

    <div class="crt-overlay"></div>
    <div class="frame"></div>

    <script>

    function confirmLogout() {
        const confirmacao = confirm("Tem certeza que deseja fazer logout?");
        if (confirmacao) {
            window.location.href = "logout.php";
        }
    }

    </script>

    <script src="js/commandBar.js"></script>
    <script src="js/profile.js"></script>

</body>
</html>
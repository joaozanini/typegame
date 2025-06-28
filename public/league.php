<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: /typegame/public/index.php");
    exit();
}

require_once __DIR__ . '/../src/Models/User.php';
if(isUserInAnyLeague($_SESSION['user_id'])) {
    header("Location: /typegame/public/leagueView.php?id=" . getLeagueIdByUserId($_SESSION['user_id']));
    exit();
}

require_once __DIR__ . '/../src/Models/League.php';
$leagues = findLeaguesWithDetails();
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
            <h1 id="title">Typos!</h1>
            <div class="buttonWrapper">
                <input type="button" class="botaon" value="Play!" onclick="window.location.href='game.php';">
                <input type="button" id="opage" class="botaon" value="Leagues"
                    onclick="window.location.href='league.php';">
                <input type="button" class="botaon" value="Profile" onclick="window.location.href='profile.php';">
            </div>
        </div>
    </div>

    <div id="main">
        <div id="cabecalho">
            <div class="botaonWrapper" style="margin: 2rem 0 0 2rem;">
                <input type="button" class="botao" value="Create" onclick="window.location.href='leagueCreate.php';">
            </div>
        </div>


        <div id="userHistory">
            <section id="historyConteiner">
                <table class="historyTable">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Members</th>
                            <th>Total Score</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($leagues)): ?>
                        <tr>
                            <td colspan="5">Nenhuma liga encontrada.</td>
                        </tr>
                        <?php else: ?>
                        <?php foreach ($leagues as $league): ?>
                        <tr>
                            <td><?= htmlspecialchars($league['id']) ?></td>
                            <td><?= htmlspecialchars($league['name']) ?></td>
                            <td><?= htmlspecialchars($league['members']) ?></td>
                            <td><?= htmlspecialchars($league['total_score']) ?></td>
                            <td>
                                <form method="POST" action="../src/Controllers/LeagueEnter.php"
                                    style="display:inline; margin-right: 0.5rem;">
                                    <input type="hidden" name="league_id" value="<?= $league['id'] ?>"
                                        style="width:1px">
                                    <input type="submit" class="botao" value="Enter">
                                </form>
                                <input type="submit" class="botao" value="View"
                                    onclick="window.location.href='leagueView.php?id=<?= $league['id'] ?>';"> 
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
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
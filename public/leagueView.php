<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: /typegame/public/index.php");
    exit();
}

require_once __DIR__ . '/../src/Models/League.php';
require_once __DIR__ . '/../src/Models/User.php';

if (!isset($_GET['league_id'])) {
    $userId = $_SESSION['user_id'];
    $leagueId = getLeagueIdByUserId($userId);

    if ($leagueId) {
        header("Location: leagueView.php?league_id=$leagueId");
        exit();
    } else {
        echo "<p style='color: red; text-align: center;'>Você não está em nenhuma liga.</p>";
        exit();
    }
}

$leagueId = (int)$_GET['league_id'];
$league = findLeagueById($leagueId);
$members = findUsersByLeague($leagueId);

if (!$league) {
    echo "<p style='color: red; text-align: center;'>Liga não encontrada.</p>";
    exit();
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
            <h1 id="title">Typos!</h1>
            <div class="buttonWrapper">
                <input type="button" class="botaon" value="Play!" onclick="window.location.href='game.php';">
                <input type="button" id="opage" class="botaon" value="Leagues" onclick="window.location.href='league.php';">
                <input type="button" class="botaon" value="Profile" onclick="window.location.href='profile.php';">
            </div>
        </div>
    </div>

    <div id="main">
    <div id="cabecalho">
        <h1 style="margin-left: 2rem;"><?= htmlspecialchars($league['name']) ?></h1>
        <h2 style="margin-right: 2rem;">| Total de Membros: <?= count($members) ?> |</h2>

        <form method="POST" action="../src/Controllers/LeagueLeave.php" style="display:inline; margin-right: 2rem;">
            <input type="hidden" name="league_id" value="<?= $league['id'] ?>" style="width:1px">
            <input type="submit" class="botao" value="Leave">
        </form>

    </div>

    <div id="userHistory">
        <section id="historyConteiner">
            <table class="historyTable">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Nickname</th>
                        <th>Score</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($members)): ?>
                        <tr>
                            <td colspan="3">Nenhum membro na liga.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($members as $user): ?>
                            <tr>
                                <td><?= htmlspecialchars($user['id']) ?></td>
                                <td><?= htmlspecialchars($user['nickname']) ?></td>
                                <td><?= htmlspecialchars($user['total_points']) ?></td>
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
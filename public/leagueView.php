<?php
session_start();

require_once __DIR__ . '/../src/Models/League.php';
require_once __DIR__ . '/../src/Models/User.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: /typegame/public/index.php");
    exit();
}

$leagueId = isset($_GET['id']) ? (int)$_GET['id'] : null;

if (!$leagueId) {
    header("Location: /typegame/public/league.php");
    exit();
}

$userId = $_SESSION['user_id'];

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
    <title>Liga - <?= htmlspecialchars($league['name']) ?></title>
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
                <input type="button" class="botaon" value="Leagues" onclick="window.location.href='league.php';">
                <input type="button" class="botaon" value="Profile" onclick="window.location.href='profile.php';">
            </div>
        </div>
    </div>

    <div id="main">
        <div id="cabecalho" style="display: flex; align-items: center; justify-content: space-between; padding: 2rem;">
            <div>
                <h1 style="margin: 0;"><?= htmlspecialchars($league['name']) ?></h1>
                <p>ID da Liga: <?= $league['id'] ?> | Membros: <?= count($members) ?></p>
            </div>
            <form method="POST" action="../src/Controllers/LeagueLeave.php" style="margin-right: 2rem;">
                <input type="hidden" name="league_id" value="<?= $league['id'] ?>">
                <input type="submit" class="botao" value="Leave">
            </form>
        </div>

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
                            <td colspan="3">Nenhum membro nesta liga.</td>
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

    <div class="crt-overlay"></div>
    <div class="frame"></div>
    <script src="js/league.js"></script>
</body>
</html>

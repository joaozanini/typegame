<?php
session_start();

require_once __DIR__ . '/../Models/League.php';
require_once __DIR__ . '/../Models/User.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: /typegame/public/index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['league_id'])) {
    header("Location: /typegame/public/league.php");
    exit();
}

$userId = $_SESSION['user_id'];
$success = leaveLeague($userId);

if ($success) {
    header("Location: /typegame/public/league.php");
    exit();
} else {
    header("Location: /typegame/public/league.php");
}

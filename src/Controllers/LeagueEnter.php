<?php
session_start();
require_once __DIR__ . '/../Models/User.php';

if (!isset($_SESSION['user_id']) || !isset($_POST['league_id'])) {
    header("Location: league.php");
    exit();
}

$userId = $_SESSION['user_id'];
$leagueId = (int) $_POST['league_id'];

if (joinLeague($userId, $leagueId)) {
    header("Location: /typegame/public/league.php");
} else {
    header("Location: /typegame/public/league.php");
}

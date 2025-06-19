<?php
require_once __DIR__ . '/../config/database.php';

// CREATE
function createGameResult($userId, $totalTime, $wpm, $accuracy, $errorCount, $points) {
    $conn = db_connect();
    $stmt = $conn->prepare("INSERT INTO historico (user_id, total_time, wpm, accuracy, error_count, points) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("idddii", $userId, $totalTime, $wpm, $accuracy, $errorCount, $points);
    $success = $stmt->execute();
    $stmt->close();
    $conn->close();
    return $success;
}

// UTILS

function findAllGameResultsByUserId($userId) {
    $conn = db_connect();
    $stmt = $conn->prepare("SELECT * FROM historico WHERE user_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $gameResults = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    $conn->close();
    return $gameResults;
}

function findAllGameResults() {
    $conn = db_connect();
    $result = $conn->query("SELECT * FROM historico");
    $gameResults = $result->fetch_all(MYSQLI_ASSOC);
    $conn->close();
    return $gameResults;
}

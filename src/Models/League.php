<?php
require_once __DIR__ . '/../config/database.php';

// CREATE
function createLeague($name, $creatorId) {
    $conn = db_connect();
    $stmt = $conn->prepare("INSERT INTO league (name, creator_id) VALUES (?, ?)");
    $stmt->bind_param("si", $name, $creatorId);
    $success = $stmt->execute();
    $stmt->close();
    $conn->close();
    return $success;
}


// DELETE
function deleteLeague($id) {
    $conn = db_connect();
    $stmt = $conn->prepare("DELETE FROM league WHERE id = ?");
    $stmt->bind_param("i", $id);
    $success = $stmt->execute();
    $stmt->close();
    $conn->close();
    return $success;
}


// UPDATE
function updateLeague($id, $name) {
    $conn = db_connect();
    $stmt = $conn->prepare("UPDATE league SET name = ? WHERE id = ?");
    $stmt->bind_param("si", $name, $id);
    $success = $stmt->execute();
    $stmt->close();
    $conn->close();
    return $success;
}


// UTILS

function findLeagueById($id) {
    $conn = db_connect();
    $stmt = $conn->prepare("SELECT * FROM league WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $league = $result->fetch_assoc();
    $stmt->close();
    $conn->close();
    return $league;
}

function findAllLeagues() {
    $conn = db_connect();
    $result = $conn->query("SELECT * FROM league");
    $leagues = $result->fetch_all(MYSQLI_ASSOC);
    $conn->close();
    return $leagues;
}

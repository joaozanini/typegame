<?php
require_once __DIR__ . '/../config/database.php';

// CREATE
function createLeague($name, $creatorId) {
    $conn = db_connect();
    $stmt = $conn->prepare("INSERT INTO league (name, creator_id) VALUES (?, ?)");
    $stmt->bind_param("si", $name, $creatorId);
    $success = $stmt->execute();
    $insertedId = $stmt->insert_id;
    $stmt->close();
    $conn->close();
    return $success ? $insertedId : false; 
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

function findLeaguesWithDetails() {
    $conn = db_connect();
    $query = "
        SELECT 
            l.id, 
            l.name, 
            COUNT(u.id) AS members, 
            COALESCE(SUM(u.total_points), 0) AS total_score
        FROM league l
        LEFT JOIN user u ON l.id = u.league_id
        GROUP BY l.id
        ORDER BY l.id
    ";
    $result = $conn->query($query);
    $leagues = $result->fetch_all(MYSQLI_ASSOC);
    $conn->close();
    return $leagues;
}



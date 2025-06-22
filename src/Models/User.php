<?php
require_once __DIR__ . '/../config/database.php';

// CREATE

function createUser($username, $nickname, $email, $hashedPassword) {
    $conn = db_connect();
    $stmt = $conn->prepare("INSERT INTO user (username, nickname, email, password_hash) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $nickname, $email, $hashedPassword);
    $success = $stmt->execute();
    $stmt->close();
    $conn->close();
    return $success;
}

// DELETE

function deleteUser($id) {
    $conn = db_connect();
    $stmt = $conn->prepare("DELETE FROM user WHERE id = ?");
    $stmt->bind_param("i", $id);
    $success = $stmt->execute();
    $stmt->close();
    $conn->close();
    return $success;
}

// UPDATE

function updateUser($id, $username, $nome, $email) {
    $conn = db_connect();
    $stmt = $conn->prepare("UPDATE user SET username = ?, nickname = ?, email = ? WHERE id = ?");
    $stmt->bind_param("sssi", $username, $nome, $email, $id);
    $success = $stmt->execute();
    $stmt->close();
    $conn->close();
    return $success;
}

function updateUserWithPassword($id, $username, $nome, $email, $hashedPassword) {
    $conn = db_connect();
    $stmt = $conn->prepare("UPDATE user SET username = ?, nickname = ?, email = ?, password_hash = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $username, $nome, $email, $hashedPassword, $id);
    $success = $stmt->execute();
    $stmt->close();
    $conn->close();
    return $success;
}

// Utils

function findUserById($id) {
    $conn = db_connect();
    $stmt = $conn->prepare("SELECT * FROM user WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();
    $conn->close();
    return $user;
}

function findUserByUsername($user) {
    $conn = db_connect();
    $stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();
    $conn->close();
    return $user;
}

function findUserByEmail($email) {
    $conn = db_connect();
    $stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();
    $conn->close();
    return $user;
}

function emailExists($email, $excludeId = null) {
    $conn = db_connect();

    if ($excludeId) {
        $stmt = $conn->prepare("SELECT id FROM user WHERE email = ? AND id != ?");
        if (!$stmt) {
            die("Erro prepare com excludeId: " . $conn->error);
        }
        $stmt->bind_param("si", $email, $excludeId);
    } else {
        $stmt = $conn->prepare("SELECT id FROM user WHERE email = ?");
        if (!$stmt) {
            die("Erro prepare sem excludeId: " . $conn->error);
        }
        $stmt->bind_param("s", $email);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $exists = $result->num_rows > 0;
    $stmt->close();
    $conn->close();
    return $exists;
}

function usernameExistsById($username, $excludeId = null) {
    $conn = db_connect();

    if ($excludeId) {
        $stmt = $conn->prepare("SELECT id FROM user WHERE username = ? AND id != ?");
        if (!$stmt) {
            die("Erro prepare com excludeId: " . $conn->error);
        }
        $stmt->bind_param("si", $email, $excludeId);
    } else {
        $stmt = $conn->prepare("SELECT id FROM user WHERE email = ?");
        if (!$stmt) {
            die("Erro prepare sem excludeId: " . $conn->error);
        }
        $stmt->bind_param("s", $username);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $exists = $result->num_rows > 0;
    $stmt->close();
    $conn->close();
    return $exists;
}

function usernameExists($username, $excludeId = null) {
    $conn = db_connect();
    if ($excludeId) {
        $stmt = $conn->prepare("SELECT id FROM user WHERE username = ? AND id != ?");
        $stmt->bind_param("si", $username, $excludeId);
    } else {
        $stmt = $conn->prepare("SELECT id FROM user WHERE username = ?");
        $stmt->bind_param("s", $username);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $exists = $result->num_rows > 0;
    $stmt->close();
    $conn->close();
    return $exists;
}

function findPublicUserByUsername($user) {
    $conn = db_connect();
    $stmt = $conn->prepare("SELECT username, nickname FROM user WHERE username = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();
    $conn->close();
    return $user;
}

function getTotalPoints($userId) {
    $conn = db_connect();
    $stmt = $conn->prepare("SELECT total_points FROM user WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $points = $result->fetch_assoc()['total_points'];
    $stmt->close();
    $conn->close();
    return $points;
}

// GAME UTILS

function addPoints($userId, $points) {
    $conn = db_connect();
    $stmt = $conn->prepare("UPDATE user SET total_points = total_points + ? WHERE id = ?");
    $stmt->bind_param("ii", $points, $userId);
    $success = $stmt->execute();
    $stmt->close();
    $conn->close();
    return $success;
}

// LEAGUE UTILS

function joinLeague($userId, $leagueId) {
    $conn = db_connect();
    $stmt = $conn->prepare("UPDATE user SET league_id = ? WHERE id = ?");
    $stmt->bind_param("ii", $leagueId, $userId);
    $success = $stmt->execute();
    $stmt->close();
    $conn->close();
    return $success;
}

function leaveLeague($userId) {
    $conn = db_connect();
    $stmt = $conn->prepare("UPDATE user SET league_id = NULL WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $success = $stmt->execute();
    $stmt->close();
    $conn->close();
    return $success;
}

function findUsersByLeague($leagueId) {
    $conn = db_connect();
    $stmt = $conn->prepare("SELECT id, nickname, total_points FROM user WHERE league_id = ?");
    $stmt->bind_param("i", $leagueId);
    $stmt->execute();
    $result = $stmt->get_result();
    $users = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    $conn->close();
    return $users;
}

function isUserInAnyLeague($userId) {
    $conn = db_connect();
    $stmt = $conn->prepare("SELECT league_id FROM user WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
    $conn->close();

    return !empty($row['league_id']);
}

function getLeagueIdByUserId($userId) {
    $conn = db_connect();
    $stmt = $conn->prepare("SELECT league_id FROM user WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
    $conn->close();

    return $row['league_id'] ?? null;
}



<?php
require_once __DIR__ . '/../config/database.php';

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
    $stmt = $conn->prepare("SELECT * FROM user WHERE user = ?");
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
        $stmt->bind_param("si", $email, $excludeId);
    } else {
        $stmt = $conn->prepare("SELECT id FROM user WHERE email = ?");
        $stmt->bind_param("s", $email);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $exists = $result->num_rows > 0;
    $stmt->close();
    $conn->close();
    return $exists;
}

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

function updateUser($id, $nome, $email) {
    $conn = db_connect();
    $stmt = $conn->prepare("UPDATE user SET nome = ?, email = ? WHERE id = ?");
    $stmt->bind_param("ssi", $nome, $email, $id);
    $success = $stmt->execute();
    $stmt->close();
    $conn->close();
    return $success;
}

function updateUserWithPassword($id, $nome, $email, $hashedPassword) {
    $conn = db_connect();
    $stmt = $conn->prepare("UPDATE user SET nome = ?, email = ?, password_hash = ? WHERE id = ?");
    $stmt->bind_param("sssi", $nome, $email, $hashedPassword, $id);
    $success = $stmt->execute();
    $stmt->close();
    $conn->close();
    return $success;
}
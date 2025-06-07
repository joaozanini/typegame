<?php
require_once __DIR__ . '/../config/database.php';

class User {
    public static function findById($id) {
        $conn = db_connect();
        $stmt = $conn->prepare("SELECT id, nome, email FROM usuarios WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
        $conn->close();
        return $user;
    }

    public static function findByEmail($email) {
        $conn = db_connect();
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
        $conn->close();
        return $user;
    }
    
    public static function emailExists($email, $excludeId = null) {
        $conn = db_connect();
        if ($excludeId) {
            $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ? AND id != ?");
            $stmt->bind_param("si", $email, $excludeId);
        } else {
            $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
            $stmt->bind_param("s", $email);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $exists = $result->num_rows > 0;
        $stmt->close();
        $conn->close();
        return $exists;
    }
    
    public static function create($nome, $email, $hashedPassword) {
        $conn = db_connect();
        $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, password_hash) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nome, $email, $hashedPassword);
        $success = $stmt->execute();
        $stmt->close();
        $conn->close();
        return $success;
    }

    public static function delete($id) {
        $conn = db_connect();
        $stmt = $conn->prepare("DELETE FROM usuarios WHERE id = ?");
        $stmt->bind_param("i", $id);
        $success = $stmt->execute();
        $stmt->close();
        $conn->close();
        return $success;
    }

    public static function update($id, $nome, $email) {
        $conn = db_connect();
        $stmt = $conn->prepare("UPDATE usuarios SET nome = ?, email = ? WHERE id = ?");
        $stmt->bind_param("ssi", $nome, $email, $id);
        $success = $stmt->execute();
        $stmt->close();
        $conn->close();
        return $success;
    }
    

    public static function updateWithPassword($id, $nome, $email, $hashedPassword) {
        $conn = db_connect();
        $stmt = $conn->prepare("UPDATE usuarios SET nome = ?, email = ?, password_hash = ? WHERE id = ?");
        $stmt->bind_param("sssi", $nome, $email, $hashedPassword, $id);
        $success = $stmt->execute();
        $stmt->close();
        $conn->close();
        return $success;
    }
}

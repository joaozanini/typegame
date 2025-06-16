<?php
require_once 'Database.php';

$applicationproperties = parse_ini_file("applicationProperties.ini");
$dbname = $applicationproperties['db.name'];

$conn = mysql_connect();

$result = $conn->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$dbname'");

if ($result->num_rows == 0) {
    if (!$conn->query("CREATE DATABASE `$dbname`")) {
        die("Erro ao criar banco '$dbname': " . $conn->error);
    }
}

$conn->select_db($dbname);

$tables = [

    "league" => "CREATE TABLE IF NOT EXISTS league (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(20) NOT NULL
    )",

    "user" => "CREATE TABLE IF NOT EXISTS user (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(20) NOT NULL UNIQUE,
        nickname VARCHAR(20) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        password_hash VARCHAR(255) NOT NULL,
        creation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        total_points INT DEFAULT 0,
        league_id INT DEFAULT NULL,
        FOREIGN KEY (league_id) REFERENCES league(id)
    )",

    "historico" => "CREATE TABLE IF NOT EXISTS historico (
        user_id INT NOT NULL,
        total_time INT NOT NULL,
        wpm FLOAT NOT NULL,
        accuracy FLOAT NOT NULL,
        error_count INT NOT NULL,
        points INT,
        FOREIGN KEY (user_id) REFERENCES user(id)
    )"
];

foreach ($tables as $table => $sql) {
    if (!$conn->query($sql)) {
        die("Erro ao criar tabela '$table': " . $conn->error);
    }
}

$checkColumn = $conn->query("SHOW COLUMNS FROM league LIKE 'creator_id'");
if ($checkColumn->num_rows === 0) {
    $alterSql = "ALTER TABLE league 
        ADD COLUMN creator_id INT NOT NULL,
        ADD FOREIGN KEY (creator_id) REFERENCES user(id)";
    if (!$conn->query($alterSql)) {
        die("Erro ao alterar tabela 'league': " . $conn->error);
    }
}

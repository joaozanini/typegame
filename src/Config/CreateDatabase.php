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
        name VARCHAR(100) NOT NULL
    )",

    "user" => "CREATE TABLE IF NOT EXISTS user (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(100) NOT NULL UNIQUE,
        nickname VARCHAR(100),
        email VARCHAR(100) NOT NULL UNIQUE,
        password_hash VARCHAR(255) NOT NULL,
        total_points INT DEFAULT 0,
        league_id INT,
        FOREIGN KEY (league_id) REFERENCES league(id)
    )",

    "historico" => "CREATE TABLE IF NOT EXISTS historico (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        correct_percent FLOAT NOT NULL,
        error_percent FLOAT NOT NULL,
        points INT DEFAULT 0,
        criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES user(id)
    )"
];

foreach ($tables as $table => $sql) {
    if (!$conn->query($sql)) {
        die("Erro ao criar tabela '$table': " . $conn->error);
    }
}

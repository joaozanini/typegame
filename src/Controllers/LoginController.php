<?php
require_once __DIR__ . '/../models/User.php';

session_start();

var_dump($_POST);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["error" => "Método HTTP não permitido."]);
    exit();
}


$email = $_POST['email'] ?? null;
$password = $_POST['password'] ?? null;

if (empty($email) || empty($password)) {
    http_response_code(400);
    echo json_encode(["error" => "Email e senha são obrigatórios."]);
    exit();
}


$user = findUserByEmail($email);

if (!$user) {
    http_response_code(401);
    echo json_encode(["error" => "Usuário não encontrado."]);
    exit();
}

if (!password_verify($password, $user['password_hash'])) {
    http_response_code(401);
    echo json_encode(["error" => "Senha incorreta."]);
    exit();
}

$_SESSION['user_id'] = $user['id'];
$_SESSION['username'] = $user['username'];
$_SESSION['nickname'] = $user['nickname'];
$_SESSION['email'] = $user['email'];

// Redireciona para game.php
header("Location: /typegame/public/game.php");
exit();

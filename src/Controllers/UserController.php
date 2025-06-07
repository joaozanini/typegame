<?php
require_once __DIR__ . '/../models/User.php';

header('Content-Type: application/json');

switch ($_SERVER["REQUEST_METHOD"]) {
    case "GET":
        handleGetRequest();
        break;

    case "POST":
        handlePostRequest();
        break;

    case "PUT":
        handlePutRequest();
        break;

    case "DELETE":
        handleDeleteRequest();
        break;

    default:
        http_response_code(405);
        echo json_encode(["error" => "Método HTTP não suportado"]);
        break;
}

function handleGetRequest() {
    session_start();

}

function handlePostRequest() {
    session_start();

    // Coletando dados do formulário
    $username = $_POST["username"] ?? null;
    $nickname = $_POST["nickname"] ?? null;
    $email = $_POST["email"] ?? null;
    $password1 = $_POST["password1"] ?? null;
    $password2 = $_POST["password2"] ?? null;

    // Validações básicas
    if (!$username || !$nickname || !$email || !$password1 || !$password2) {
        http_response_code(400);
        echo json_encode(["error" => "Todos os campos são obrigatórios."]);
        return;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo json_encode(["error" => "Formato de e-mail inválido."]);
        return;
    }

    if (emailExists($email)) {
        http_response_code(409);
        echo json_encode(["error" => "Este e-mail já está em uso."]);
        return;
    }

    if ($password1 !== $password2) {
        http_response_code(400);
        echo json_encode(["error" => "As senhas não coincidem."]);
        return;
    }

    $hashedPassword = password_hash($password1, PASSWORD_DEFAULT);

    if (createUser($username, $nickname, $email, $hashedPassword)) {
        header("Location: /typegame/public/index.php");
        exit();
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Erro ao criar o usuário."]);
    }
}

function handlePutRequest() {
    parse_str(file_get_contents("php://input"), $putData);
    session_start();
}

function handleDeleteRequest() {
    session_start();
}

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

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo json_encode(["error" => "Formato de e-mail inválido."]);
        return;
    }

    if (User::emailExists($email)) {
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
}

function handlePutRequest() {
    parse_str(file_get_contents("php://input"), $putData);
    session_start();
}

function handleDeleteRequest() {
    session_start();
}

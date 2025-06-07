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
    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        echo json_encode(["error" => "Usuário não autenticado"]);
        return;
    }

    $user = User::findById($_SESSION['user_id']);

    if ($user) {
        echo json_encode($user);
    } else {
        http_response_code(404);
        echo json_encode(["error" => "Usuário não encontrado"]);
    }
}

function handlePostRequest() {
    $name = htmlspecialchars(trim($_POST['fname'] ?? ''));
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $password1 = $_POST['password1'] ?? null;
    $password2 = $_POST['password2'] ?? null;

    if (!$name || !$email || !$password1 || !$password2) {
        http_response_code(400);
        echo json_encode(["error" => "Todos os campos são obrigatórios."]);
        return;
    }

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

    if (User::create($name, $email, $hashedPassword)) {
        http_response_code(201);
        echo json_encode([
            "message" => "Usuário criado com sucesso",
            "user" => ["nome" => $name, "email" => $email]
        ]);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Erro ao criar usuário"]);
    }
}

function handlePutRequest() {
    parse_str(file_get_contents("php://input"), $putData);
    session_start();

    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        echo json_encode(["error" => "Usuário não autenticado"]);
        return;
    }

    $userId = $_SESSION['user_id'];
    $name = htmlspecialchars(trim($putData['fname'] ?? ''));
    $email = filter_var(trim($putData['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $password1 = $putData['password1'] ?? null;
    $password2 = $putData['password2'] ?? null;

    if (!$name || !$email) {
        http_response_code(400);
        echo json_encode(["error" => "Nome e e-mail são obrigatórios."]);
        return;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo json_encode(["error" => "Formato de e-mail inválido."]);
        return;
    }

    if (User::emailExists($email, $userId)) {
        http_response_code(409);
        echo json_encode(["error" => "Este e-mail já está em uso por outro usuário."]);
        return;
    }

    $updateSuccess = false;

    if ($password1 || $password2) {
        if ($password1 !== $password2) {
            http_response_code(400);
            echo json_encode(["error" => "As senhas não coincidem."]);
            return;
        }
        $hashedPassword = password_hash($password1, PASSWORD_DEFAULT);
        $updateSuccess = User::updateWithPassword($userId, $name, $email, $hashedPassword);
    } else {
        $updateSuccess = User::update($userId, $name, $email);
    }

    if ($updateSuccess) {
        http_response_code(200);
        echo json_encode([
            "message" => "Usuário atualizado com sucesso",
            "user" => ["nome" => $name, "email" => $email]
        ]);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Erro ao atualizar usuário"]);
    }
}

function handleDeleteRequest() {
    session_start();
    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        echo json_encode(["error" => "Usuário não autenticado"]);
        return;
    }

    if (User::delete($_SESSION['user_id'])) {
        session_destroy();
        http_response_code(200);
        echo json_encode(["message" => "Usuário excluído com sucesso"]);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Erro ao excluir usuário"]);
    }
}

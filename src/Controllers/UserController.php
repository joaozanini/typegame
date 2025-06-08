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

// Handlers


function handleGetRequest() {
    session_start();

    if (isset($_SESSION['user_id'])) {
        $response = [
            'id' => $_SESSION['user_id'],
            'username' => $_SESSION['username'],
            'nickname' => $_SESSION['nickname'],
            'email' => $_SESSION['email']
        ];
        echo json_encode($response);
    } else {
        http_response_code(401); // Não autorizado
        echo json_encode(['error' => 'Usuário não autenticado.']);
    }
}



function handlePostRequest() {
    session_start();

    // Coletando dados do formulário
    $username = $_POST["username"];
    $nickname = $_POST["nickname"];
    $email = $_POST["email"];
    $password1 = $_POST["password1"];
    $password2 = $_POST["password2"];

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

    $user = findUserByEmail($email);

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['nickname'] = $user['nickname'];
    $_SESSION['email'] = $user['email'];

    // Redirecionar
    header("Location: /typegame/public/index.php");
    exit();
    
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Erro ao criar o usuário."]);
    }
}


function handlePutRequest() {
    session_start();
    parse_str(file_get_contents("php://input"), $putData);

    $id = $_SESSION['user_id'];
    $username = $putData['username'];
    $nome = $putData['nome'];
    $email = $putData['email'];
    $password1 = $putData['password1'];
    $password2 = $putData['password2'];

    if (!$username || !$nome || !$email) {
        http_response_code(400);
        echo json_encode(["error" => "Username, nome e e-mail são obrigatórios."]);
        return;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo json_encode(["error" => "Formato de e-mail inválido."]);
        return;
    }

    if (emailExists($email, $id)) {
        http_response_code(409);
        echo json_encode(["error" => "Este e-mail já está em uso."]);
        return;
    }

    if (usernameExists($username, $id)) {
        http_response_code(409);
        echo json_encode(["error" => "Este nome de usuário já está em uso."]);
        return;
    }

    if ($password1 && $password2) {
        if ($password1 !== $password2) {
            http_response_code(400);
            echo json_encode(["error" => "As senhas não coincidem."]);
            return;
        }

        $hashedPassword = password_hash($password1, PASSWORD_DEFAULT);
        $success = updateUserWithPassword($id, $username, $nome, $email, $hashedPassword);
    } else {
        $success = updateUser($id, $username, $nome, $email);
    }

    if ($success) {
        $_SESSION['username'] = $username;
        $_SESSION['nickname'] = $nome;
        $_SESSION['email'] = $email;
        http_response_code(200);
        echo json_encode(["message" => "Usuário atualizado com sucesso."]);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Erro ao atualizar usuário."]);
    }
}


function handleDeleteRequest() {
    session_start();

    $id = $_SESSION['user_id'];

    if (deleteUser($id)) {
        session_destroy();
        http_response_code(200);
        echo json_encode(["message" => "Usuário excluído com sucesso."]);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Erro ao excluir o usuário."]);
    }
}

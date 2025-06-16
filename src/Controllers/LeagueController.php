<?php
require_once __DIR__ . '/../models/League.php';
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
        echo json_encode(["error" => "Usuário não autenticado."]);
        return;
    }

    $leagues = findAllLeagues();
    echo json_encode($leagues);
}

function handlePostRequest() {
    session_start();

    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        echo json_encode(["error" => "Usuário não autenticado."]);
        return;
    }

    $name = $_POST['name'] ?? null;

    if (!$name) {
        http_response_code(400);
        echo json_encode(["error" => "Nome da liga é obrigatório."]);
        return;
    }

    $creatorId = $_SESSION['user_id'];

    $success = createLeague($name, $creatorId);

    if ($success) {
        http_response_code(201);
        echo json_encode(["message" => "Liga criada com sucesso."]);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Erro ao criar a liga."]);
    }
}

function handlePutRequest() {
    session_start();

    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        echo json_encode(["error" => "Usuário não autenticado."]);
        return;
    }

    parse_str(file_get_contents("php://input"), $putData);

    $leagueId = $putData['id'] ?? null;
    $name = $putData['name'] ?? null;

    if (!$leagueId || !$name) {
        http_response_code(400);
        echo json_encode(["error" => "ID e nome da liga são obrigatórios."]);
        return;
    }

    $userId = $_SESSION['user_id'];

    $league = findLeagueById($leagueId);
    if (!$league) {
        http_response_code(404);
        echo json_encode(["error" => "Liga não encontrada."]);
        return;
    }

    if ($league['creator_id'] != $userId) {
        http_response_code(403);
        echo json_encode(["error" => "Você não tem permissão para editar essa liga."]);
        return;
    }

    $success = updateLeague($leagueId, $name);

    if ($success) {
        http_response_code(200);
        echo json_encode(["message" => "Liga atualizada com sucesso."]);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Erro ao atualizar a liga."]);
    }
}

function handleDeleteRequest() {
    session_start();

    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        echo json_encode(["error" => "Usuário não autenticado."]);
        return;
    }

    parse_str(file_get_contents("php://input"), $deleteData);
    $leagueId = $deleteData['id'] ?? null;

    if (!$leagueId) {
        http_response_code(400);
        echo json_encode(["error" => "ID da liga é obrigatório."]);
        return;
    }

    $userId = $_SESSION['user_id'];

    $league = findLeagueById($leagueId);
    if (!$league) {
        http_response_code(404);
        echo json_encode(["error" => "Liga não encontrada."]);
        return;
    }

    if ($league['creator_id'] != $userId) {
        http_response_code(403);
        echo json_encode(["error" => "Você não tem permissão para excluir essa liga."]);
        return;
    }

    $success = deleteLeague($leagueId);

    if ($success) {
        http_response_code(200);
        echo json_encode(["message" => "Liga excluída com sucesso."]);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Erro ao excluir a liga."]);
    }
}

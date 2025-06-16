<?php
require_once __DIR__ . '/../models/GameResult.php';
session_start();

header('Content-Type: application/json');

switch ($_SERVER["REQUEST_METHOD"]) {
    case "GET":
        handleGetRequest();
        break;

    case "POST":
        handlePostRequest();
        break;

    default:
        http_response_code(405);
        echo json_encode(["error" => "Método HTTP não suportado"]);
        break;
}

function handleGetRequest() {
    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        echo json_encode(["error" => "Usuário não autenticado."]);
        return;
    }

    $userId = $_SESSION['user_id'];
    $gameResult = findGameResultByUserId($userId);

    if ($gameResult) {
        echo json_encode($gameResult);
    } else {
        http_response_code(404);
        echo json_encode(["error" => "Resultado de jogo não encontrado para o usuário."]);
    }
}

function handlePostRequest() {
    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        echo json_encode(["error" => "Usuário não autenticado."]);
        return;
    }

    $input = json_decode(file_get_contents("php://input"), true);

    $totalTime = isset($input['time']) ? (int)$input['time'] : null;
    $wpm = isset($input['wpm']) ? (float)$input['wpm'] : null;
    $accuracy = isset($input['accuracy']) ? (float)$input['accuracy'] : null;
    $errorCount = isset($input['errors']) ? (int)$input['errors'] : null;
    $points = calculatePoints($wpm, $accuracy, $errorCount);

    if ($totalTime === null || $wpm === null || $accuracy === null || $errorCount === null) {
        http_response_code(400);
        echo json_encode(["error" => "Campos time, wpm, accuracy e errors são obrigatórios."]);
        return;
    }

    $userId = $_SESSION['user_id'];

    $success = createGameResult($userId, $totalTime, $wpm, $accuracy, $errorCount, $points);

    if ($success) {
        http_response_code(201);
        echo json_encode(["message" => "Resultado de jogo criado com sucesso."]);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Erro ao criar resultado de jogo."]);
    }
}

function calculatePoints($wpm, $accuracy, $errorCount) {
    $basePoints = $wpm * ($accuracy / 100);
    $penalty = $errorCount * 2;
    $points = max(0, round($basePoints - $penalty));
    return $points;
}

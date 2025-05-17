<?php

require_once '../classes/Client.php';
require_once '../classes/Card.php';
require_once '../classes/Ticket.php';
require_once '../classes/Posnet.php';
require_once '../classes/CardStorageInterface.php';
require_once '../classes/JsonCardStorage.php';

header('Content-Type: application/json');

$storage = new JsonCardStorage(); // o cambiar por MySQL
$posnet = new Posnet($storage);

$method = $_SERVER['REQUEST_METHOD'];
$path = $_GET['action'] ?? '';

try {
    if ($method === 'POST' && $path === 'register') {
        $body = json_decode(file_get_contents('php://input'), true);

        $client = new Client($body['dni'], $body['first_name'], $body['last_name']);
        $card = new Card($body['type'], $body['bank'], $body['number'], $body['limit'], $client);

        $posnet->registerCard($card);

        http_response_code(201);
        echo json_encode(['message' => 'Card registered successfully']);
        exit;
    }

    if ($method === 'POST' && $path === 'pay') {
        $body = json_decode(file_get_contents('php://input'), true);

        $ticket = $posnet->doPayment($body['number'], $body['amount'], $body['installments']);

        echo json_encode($ticket->toArray());
        exit;
    }

    http_response_code(404);
    echo json_encode(['error' => 'Endpoint not found']);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['error' => $e->getMessage()]);
}

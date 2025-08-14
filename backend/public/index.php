<?php
// Configuración básica
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Headers CORS simples
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

// Manejar preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

try {
    // Cargar clases
    require_once __DIR__ . '/../src/utils/Database.php';
    require_once __DIR__ . '/../src/utils/Response.php';
    require_once __DIR__ . '/../routes/api.php';

    // Conectar base de datos
    $db = Database::getInstance();

    // Manejar peticiones
    $router = new ApiRouter();
    $router->handleRequest();
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error del servidor'
    ]);
}

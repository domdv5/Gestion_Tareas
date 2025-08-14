<?php
require_once __DIR__ . '/../src/controllers/TaskController.php';
require_once __DIR__ . '/../src/utils/Response.php';
require_once __DIR__ . '/../src/utils/Database.php';

class ApiRouter
{
    private $taskController;

    public function __construct()
    {
        try {
            $database = Database::getInstance();
            $db = $database->getConnection();


            $this->taskController = new TaskController($db);
        } catch (Exception $e) {
            $response = new Response();
            $response->error('Error al inicializar la aplicación: ' . $e->getMessage(), 500);
        }
    }

    public function handleRequest()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = $this->getPath();



        switch (true) {

            case $method === 'GET' && $path === '/api/tasks':
                $this->taskController->getAllTasks();
                break;


            case $method === 'POST' && $path === '/api/tasks':
                $this->taskController->createTask();
                break;



            case $method === 'PUT' && preg_match('/^\/api\/tasks\/(\d+)$/', $path, $matches):
                $this->taskController->updateTask($matches[1]);
                break;


            case $method === 'DELETE' && preg_match('/^\/api\/tasks\/(\d+)$/', $path, $matches):
                $this->taskController->deleteTask($matches[1]);
                break;


            default:
                $response = new Response();
                $response->error("Endpoint no encontrado. Ruta: $path, Método: $method", 404);
        }
    }

    private function getPath()
    {
        $uri = $_SERVER['REQUEST_URI'];
        $path = parse_url($uri, PHP_URL_PATH);

        // Remover prefijos comunes de Laragon
        $prefixes = [
            '/Gestion_tareas/backend/public',
            '/Gestion_tareas/backend',
            '/backend/public',
            '/backend'
        ];

        foreach ($prefixes as $prefix) {
            if (strpos($path, $prefix) === 0) {
                $path = substr($path, strlen($prefix));
                break;
            }
        }

        // Asegurar que empiece con /
        if (!str_starts_with($path, '/')) {
            $path = '/' . $path;
        }

        return $path;
    }
}

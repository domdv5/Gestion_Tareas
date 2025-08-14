<?php

/**
 * Middleware para el manejo de CORS (Cross-Origin Resource Sharing)
 * 
 * Esta clase se encarga de gestionar las políticas de intercambio de recursos
 * de origen cruzado, permitiendo que las aplicaciones web ejecutándose en un
 * dominio accedan a recursos de otro dominio de manera segura.
 * 
 * Funcionalidades principales:
 * - Configura los headers necesarios para CORS
 * - Permite especificar orígenes permitidos
 * - Maneja solicitudes preflight (OPTIONS)
 * - Establece métodos HTTP permitidos
 * - Configura headers permitidos y expuestos
 * 
 * @package Middleware
 * @author Tu Nombre
 * @version 1.0
 * @since 1.0
 */
class CorsMiddleware
{

    public static function handle()
    {
        $config = require_once __DIR__ . '/../../config/config.php';
        $corsConfig = $config['cors'];

        $origin = $_SERVER['HTTP_ORIGIN'] ?? '';


        if (in_array($origin, $corsConfig['allowed_origins'])) {
            header("Access-Control-Allow-Origin: {$origin}");
        }


        header("Access-Control-Allow-Methods: " . implode(', ', $corsConfig['allowed_methods']));
        header("Access-Control-Allow-Headers: " . implode(', ', $corsConfig['allowed_headers']));
        header("Access-Control-Allow-Credentials: true");
        header("Access-Control-Max-Age: 86400"); // 24 horas


        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit;
        }
    }

    public static function setJsonHeader()
    {
        header('Content-Type: application/json; charset=utf-8');
    }
}

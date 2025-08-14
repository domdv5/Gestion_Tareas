<?php
class Response
{
    // Respuesta exitosa
    public static function success($data = null, $message = "OK")
    {
        http_response_code(200);
        echo json_encode([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // Respuesta de error
    public static function error($message, $code = 400)
    {
        http_response_code($code);
        echo json_encode([
            'success' => false,
            'message' => $message
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // Métodos específicos
    public static function created($data, $message = "Creado exitosamente")
    {
        http_response_code(201);
        echo json_encode([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    public static function notFound($message = "No encontrado")
    {
        self::error($message, 404);
    }

    public static function badRequest($message = "Solicitud incorrecta", $errors = null)
    {
        http_response_code(400);
        $response = [
            'success' => false,
            'message' => $message
        ];
        if ($errors) {
            $response['errors'] = $errors;
        }
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit;
    }

    public static function internalError($message = "Error del servidor")
    {
        self::error($message, 500);
    }
}

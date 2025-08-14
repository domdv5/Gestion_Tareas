<?php

/**
 * Clase Validator
 * 
 * Proporciona métodos para validar diferentes tipos de datos y formatos.
 * Esta clase contiene funciones de utilidad para validar entradas de usuario,
 * formatos de datos, y aplicar reglas de validación en la aplicación.
 * 
 */
class Validator
{
    // Validar que el ID sea válido
    public static function isValidId($id)
    {
        return is_numeric($id) && $id > 0;
    }

    // Validar datos de tarea (más simple)
    public static function validateTaskData($data)
    {
        $errors = [];

        // Validar título
        if (empty(trim($data['title'] ?? ''))) {
            $errors[] = "El título es obligatorio";
        } elseif (strlen(trim($data['title'])) > 255) {
            $errors[] = "El título no puede tener más de 255 caracteres";
        }

        // Validar descripción
        if (empty(trim($data['description'] ?? ''))) {
            $errors[] = "La descripción es obligatoria";
        } elseif (strlen(trim($data['description'])) > 1000) {
            $errors[] = "La descripción no puede tener más de 1000 caracteres";
        }

        // Validar estado
        $validStatuses = ['pending', 'completed'];
        if (!in_array($data['status'] ?? '', $validStatuses)) {
            $errors[] = "El estado debe ser 'pending' o 'completed'";
        }

        return $errors;
    }
}

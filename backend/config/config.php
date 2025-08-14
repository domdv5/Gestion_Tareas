<?php
// Configuración general de la aplicación
return [
    'app_name' => 'Sistema de Gestión de Tareas',
    'app_version' => '1.0.0',
    'timezone' => 'America/Mexico_City',
    'cors' => [
        'allowed_origins' => ['*'],
        'allowed_methods' => ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
        'allowed_headers' => ['Content-Type', 'Authorization', 'X-Requested-With'],
    ],
    'api' => [
        'base_path' => '/api',
        'version' => 'v1',
    ]
];

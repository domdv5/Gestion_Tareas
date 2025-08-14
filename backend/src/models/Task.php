<?php
require_once __DIR__ . '/../utils/Validator.php';

class Task
{
    private $id;
    private $title;
    private $description;
    private $status;
    private $created_at;
    private $updated_at;

    public function __construct($data = [])
    {
        $this->id = $data['id'] ?? null;
        $this->title = $data['title'] ?? '';
        $this->description = $data['description'] ?? '';
        $this->status = $data['status'] ?? 'pending';
        $this->created_at = $data['created_at'] ?? null;
        $this->updated_at = $data['updated_at'] ?? null;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    // Convertir a array para JSON (compatible con frontend React)
    public function toArray()
    {
        return [
            'id' => (int)$this->id,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'completed' => $this->status === 'completed',
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at
        ];
    }

    // Validar datos del modelo
    public function validate()
    {
        return Validator::validateTaskData([
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status
        ]);
    }

    // Crear desde datos del frontend (adaptador)
    public static function fromFrontend($data)
    {
        $taskData = [
            'id' => $data['id'] ?? null,
            'title' => $data['name'] ?? $data['title'] ?? '',
            'description' => $data['description'] ?? '',
            'status' => isset($data['completed'])
                ? ($data['completed'] ? 'completed' : 'pending')
                : ($data['status'] ?? 'pending')
        ];

        return new self($taskData);
    }
}

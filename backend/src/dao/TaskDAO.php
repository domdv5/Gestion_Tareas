<?php
require_once __DIR__ . '/interfaces/TaskDAOInterface.php';
require_once __DIR__ . '/../models/Task.php';

/**
 * Clase de acceso a datos para la gestión de tareas
 * 
 * Esta clase implementa la interfaz TaskDAOInterface y proporciona
 * métodos para realizar operaciones CRUD (Crear, Leer, Actualizar, Eliminar)
 * sobre las tareas en la base de datos.
 */
class TaskDAO implements TaskDAOInterface
{
    private $db;
    private $table = 'tareas';

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function findAll()
    {
        try {
            $query = "SELECT * FROM {$this->table} ORDER BY created_at DESC";
            $stmt = $this->db->prepare($query);
            $stmt->execute();

            $tasks = [];
            while ($row = $stmt->fetch()) {
                $tasks[] = new Task($row);
            }
            return $tasks;
        } catch (Exception $e) {
            throw new Exception("Error al obtener las tareas: " . $e->getMessage());
        }
    }

    public function create(Task $task)
    {
        try {
            $query = "INSERT INTO {$this->table} 
                      (title, description, status, created_at, updated_at)
                      VALUES (?, ?, ?, NOW(), NOW())
                      RETURNING *";

            $stmt = $this->db->prepare($query);
            $stmt->execute([
                $task->getTitle(),
                $task->getDescription(),
                $task->getStatus()
            ]);

            $row = $stmt->fetch();
            return $row ? new Task($row) : false;
        } catch (Exception $e) {
            throw new Exception("Error al crear la tarea: " . $e->getMessage());
        }
    }

    public function update(Task $task)
    {
        try {
            $query = "UPDATE {$this->table}
                      SET title = ?, description = ?, status = ?, updated_at = NOW()
                      WHERE id = ?
                      RETURNING *";

            $stmt = $this->db->prepare($query);
            $stmt->execute([
                $task->getTitle(),
                $task->getDescription(),
                $task->getStatus(),
                $task->getId()
            ]);

            $row = $stmt->fetch();
            return $row ? new Task($row) : false;
        } catch (Exception $e) {
            throw new Exception("Error al actualizar la tarea: " . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $query = "DELETE FROM {$this->table} WHERE id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id]);
            return $stmt->rowCount() > 0;
        } catch (Exception $e) {
            throw new Exception("Error al eliminar la tarea: " . $e->getMessage());
        }
    }
}

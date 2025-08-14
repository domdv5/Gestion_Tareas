<?php
require_once __DIR__ . '/../dao/TaskDAO.php';
require_once __DIR__ . '/../models/Task.php';
require_once __DIR__ . '/../utils/Response.php';
require_once __DIR__ . '/../utils/Validator.php';

class TaskController
{
    private $taskDAO;

    public function __construct($db)
    {
        $this->taskDAO = new TaskDAO($db);
    }

    // GET /api/tasks - Obtener todas las tareas
    public function getAllTasks()
    {
        try {
            $tasks = $this->taskDAO->findAll();
            $tasksArray = array_map(function ($task) {
                return $task->toArray();
            }, $tasks);
            Response::success($tasksArray, 'Tareas obtenidas exitosamente');
        } catch (Exception $e) {
            Response::internalError('Error al obtener las tareas');
        }
    }

    // POST /api/tasks - Crear una nueva tarea
    public function createTask()
    {
        try {
            $input = json_decode(file_get_contents('php://input'), true);
            if (!$input) {
                Response::badRequest('Datos JSON inválidos');
                return;
            }

            $task = Task::fromFrontend($input);
            $errors = $task->validate();
            if (!empty($errors)) {
                Response::badRequest('Datos de tarea inválidos', $errors);
                return;
            }

            $savedTask = $this->taskDAO->create($task);
            if ($savedTask) {
                Response::created($savedTask->toArray(), 'Tarea creada exitosamente');
            } else {
                Response::internalError('Error al crear la tarea');
            }
        } catch (Exception $e) {
            Response::internalError('Error al crear la tarea');
        }
    }

    // PUT /api/tasks/{id} - Actualizar una tarea
    public function updateTask($id)
    {
        try {
            if (!Validator::isValidId($id)) {
                Response::badRequest('ID de tarea inválido');
                return;
            }

            $input = json_decode(file_get_contents('php://input'), true);
            if (!$input) {
                Response::badRequest('Datos JSON inválidos');
                return;
            }

            $taskData = [
                'id' => $id,
                'title' => $input['title'] ?? $input['name'] ?? '',
                'description' => $input['description'] ?? '',
                'status' => isset($input['completed'])
                    ? ($input['completed'] ? 'completed' : 'pending')
                    : ($input['status'] ?? 'pending')
            ];

            $task = new Task($taskData);
            $errors = $task->validate();
            if (!empty($errors)) {
                Response::badRequest('Datos de tarea inválidos', $errors);
                return;
            }

            $updatedTask = $this->taskDAO->update($task);
            if ($updatedTask) {
                Response::success($updatedTask->toArray(), 'Tarea actualizada exitosamente');
            } else {
                Response::notFound('Tarea no encontrada');
            }
        } catch (Exception $e) {
            Response::internalError('Error al actualizar la tarea');
        }
    }

    // DELETE /api/tasks/{id} - Eliminar una tarea
    public function deleteTask($id)
    {
        try {
            if (!Validator::isValidId($id)) {
                Response::badRequest('ID de tarea inválido');
                return;
            }

            $deleted = $this->taskDAO->delete($id);
            if ($deleted) {
                Response::success(null, 'Tarea eliminada exitosamente');
            } else {
                Response::notFound('Tarea no encontrada');
            }
        } catch (Exception $e) {
            Response::internalError('Error al eliminar la tarea');
        }
    }
}

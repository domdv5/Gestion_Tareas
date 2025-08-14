<?php
interface TaskDAOInterface
{
    /**
     * Obtener todas las tareas
     * @return array
     */
    public function findAll();

    /**
     * Crear una nueva tarea
     * @param Task $task
     * @return Task|false
     */
    public function create(Task $task);

    /**
     * Actualizar una tarea existente
     * @param Task $task
     * @return Task|false
     */
    public function update(Task $task);

    /**
     * Eliminar una tarea
     * @param int $id
     * @return bool
     */
    public function delete($id);
}

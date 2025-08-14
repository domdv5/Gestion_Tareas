import { useState, useEffect } from "react";
import { API_ENDPOINTS } from "../config/api";

export const useTasks = () => {
  const [tasks, setTasks] = useState([]);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState(null);

  // Función para cargar las tareas desde la API
  const fetchTasks = async () => {
    try {
      setLoading(true);
      setError(null);

      const response = await fetch(API_ENDPOINTS.TASKS);
      const result = await response.json();

      if (result.success) {
        setTasks(result.data || []);
      } else {
        setError(result.message || "Error al cargar las tareas");
      }
    } catch (err) {
      console.error("Error fetching tasks:", err);
      setError("Error al conectar con el servidor");
    } finally {
      setLoading(false);
    }
  };

  // Ejecutar fetchTasks cuando el componente se monte
  useEffect(() => {
    fetchTasks();
  }, []); // Array vacío significa que solo se ejecuta al montar

  const addTask = async (taskData) => {
    try {
      setLoading(true);
      setError(null);

      const response = await fetch(API_ENDPOINTS.TASKS, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          title: taskData.name || taskData.title,
          description: taskData.description || "",
        }),
      });

      const result = await response.json();

      if (result.success) {
        // Recargar las tareas para obtener los datos actualizados del servidor
        await fetchTasks();
      } else {
        setError(result.message || "Error al crear la tarea");
      }
    } catch (err) {
      console.error("Error adding task:", err);
      setError("Error al conectar con el servidor");
    } finally {
      setLoading(false);
    }
  };

  const updateTask = async (taskId, taskData) => {
    try {
      setLoading(true);
      setError(null);

      const response = await fetch(`${API_ENDPOINTS.TASKS}/${taskId}`, {
        method: "PUT",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(taskData),
      });

      const result = await response.json();

      if (result.success) {
        // Actualizar el estado local inmediatamente
        setTasks((prevTasks) =>
          prevTasks.map((task) =>
            task.id === taskId ? { ...task, ...taskData } : task
          )
        );
      } else {
        setError(result.message || "Error al actualizar la tarea");
      }
    } catch (err) {
      console.error("Error updating task:", err);
      setError("Error al conectar con el servidor");
    } finally {
      setLoading(false);
    }
  };

  const deleteTask = async (taskId) => {
    try {
      setLoading(true);
      setError(null);

      const response = await fetch(`${API_ENDPOINTS.TASKS}/${taskId}`, {
        method: "DELETE",
      });

      const result = await response.json();

      if (result.success) {
        setTasks((prevTasks) => prevTasks.filter((task) => task.id !== taskId));
      } else {
        setError(result.message || "Error al eliminar la tarea");
      }
    } catch (err) {
      console.error("Error deleting task:", err);
      setError("Error al conectar con el servidor");
    } finally {
      setLoading(false);
    }
  };

  const toggleTaskCompletion = async (taskId) => {
    const task = tasks.find((t) => t.id === taskId);
    if (!task) return;

    try {
      setLoading(true);
      setError(null);

      const response = await fetch(`${API_ENDPOINTS.TASKS}/${taskId}`, {
        method: "PUT",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          ...task,
          completed: !task.completed,
        }),
      });

      const result = await response.json();

      if (result.success) {
        setTasks((prevTasks) =>
          prevTasks.map((t) =>
            t.id === taskId ? { ...t, completed: !t.completed } : t
          )
        );
      } else {
        setError(result.message || "Error al actualizar la tarea");
      }
    } catch (err) {
      console.error("Error toggling task:", err);
      setError("Error al conectar con el servidor");
    } finally {
      setLoading(false);
    }
  };

  return {
    tasks,
    loading,
    error,
    addTask,
    updateTask,
    deleteTask,
    toggleTaskCompletion,
    refetch: fetchTasks,
  };
};

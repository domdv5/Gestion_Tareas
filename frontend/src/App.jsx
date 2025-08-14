import "./App.css";
import Layout from "./components/Layout/Layout";
import TaskForm from "./components/TaskForm/TaskForm";
import TaskList from "./components/TaskList/TaskList";
import { useTasks } from "./hooks/useTasks";

const App = () => {
  const { tasks, addTask, updateTask, deleteTask, toggleTaskCompletion } =
    useTasks();

  return (
    <Layout>
      <header className="app-header">
        <h1>📋 Sistema de Gestión de Tareas</h1>
        <div className="task-stats">
          <span className="stat-item">
            Total: <strong>{tasks.length}</strong>
          </span>
          <span className="stat-item">
            Pendientes:{" "}
            <strong>{tasks.filter((t) => !t.completed).length}</strong>
          </span>
          <span className="stat-item">
            Completadas:{" "}
            <strong>{tasks.filter((t) => t.completed).length}</strong>
          </span>
        </div>
      </header>

      <TaskForm addTask={addTask} />

      <TaskList
        tasks={tasks}
        deleteTask={deleteTask}
        toggleTaskCompletion={toggleTaskCompletion}
        updateTask={updateTask}
      />

      {tasks.length === 0 && (
        <div className="empty-state">
          <p>No tienes tareas aún. ¡Crea tu primera tarea arriba! 🚀</p>
        </div>
      )}
    </Layout>
  );
};

export default App;

import React, { useState } from "react";
import "./TaskItem.css";

const TaskItem = ({ task, onDelete, onToggle, onUpdate }) => {
  const [isEditing, setIsEditing] = useState(false);
  const [editedTitle, setEditedTitle] = useState(task.title);
  const [editedDescription, setEditedDescription] = useState(
    task.description || ""
  );

  const handleSave = () => {
    if (editedTitle.trim()) {
      onUpdate(task.id, {
        title: editedTitle.trim(),
        description: editedDescription.trim(),
      });
      setIsEditing(false);
    }
  };

  const handleCancel = () => {
    setEditedTitle(task.title);
    setEditedDescription(task.description || "");
    setIsEditing(false);
  };

  const handleKeyPress = (e) => {
    if (e.key === "Enter" && !e.shiftKey) {
      e.preventDefault();
      handleSave();
    } else if (e.key === "Escape") {
      handleCancel();
    }
  };
  return (
    <div className={`task-item ${task.completed ? "completed" : ""}`}>
      <div className="task-content">
        {isEditing ? (
          <div className="task-edit-form">
            <input
              type="text"
              value={editedTitle}
              onChange={(e) => setEditedTitle(e.target.value)}
              onKeyPress={handleKeyPress}
              className="edit-title-input"
              placeholder="Título de la tarea..."
              autoFocus
            />
            <textarea
              value={editedDescription}
              onChange={(e) => setEditedDescription(e.target.value)}
              onKeyPress={handleKeyPress}
              className="edit-description-input"
              placeholder="Descripción de la tarea..."
              rows="3"
            />
            <div className="edit-actions">
              <button
                onClick={handleSave}
                className="save-button"
                title="Guardar cambios"
              >
                ✓
              </button>
              <button
                onClick={handleCancel}
                className="cancel-button"
                title="Cancelar edición"
              >
                ✕
              </button>
            </div>
          </div>
        ) : (
          <>
            <h3
              className={`task-title ${task.completed ? "completed" : ""}`}
              onClick={() => setIsEditing(true)}
              title="Haz clic para editar"
            >
              {task.title}
            </h3>
            {task.description && (
              <p
                className={`task-description ${
                  task.completed ? "completed" : ""
                }`}
                onClick={() => setIsEditing(true)}
                title="Haz clic para editar"
              >
                {task.description}
              </p>
            )}
          </>
        )}

        <div className="task-meta">
          <span
            className={`task-status ${
              task.completed ? "completed" : "pending"
            }`}
          >
            {task.completed ? "Completada" : "Pendiente"}
          </span>
          {task.createdAt && (
            <span className="task-date">
              Creada: {new Date(task.createdAt).toLocaleDateString()}
            </span>
          )}
        </div>
      </div>
      <div className="task-actions">
        {!isEditing && (
          <>
            <button
              className="edit-button"
              onClick={() => setIsEditing(true)}
              title="Editar tarea"
            >
              ✏️
            </button>
            <button
              className={`toggle-button ${
                task.completed ? "undo" : "complete"
              }`}
              onClick={() => onToggle(task.id)}
              title={
                task.completed
                  ? "Marcar como pendiente"
                  : "Marcar como completada"
              }
            >
              {task.completed ? "↶" : "✓"}
            </button>
            <button
              className="delete-button"
              onClick={() => onDelete(task.id)}
              title="Eliminar tarea"
            >
              🗑️
            </button>
          </>
        )}
      </div>
    </div>
  );
};

export default TaskItem;

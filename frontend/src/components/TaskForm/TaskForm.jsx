import React, { useState } from "react";
import "./TaskForm.css";

const TaskForm = ({ addTask }) => {
  const [title, setTitle] = useState("");
  const [description, setDescription] = useState("");
  const [isSubmitting, setIsSubmitting] = useState(false);
  const [errors, setErrors] = useState({ title: "", description: "" });

  const validateForm = () => {
    const newErrors = { title: "", description: "" };
    let isValid = true;

    if (!title.trim()) {
      newErrors.title = "El título es obligatorio";
      isValid = false;
    }

    if (!description.trim()) {
      newErrors.description = "La descripción es obligatoria";
      isValid = false;
    }

    setErrors(newErrors);
    return isValid;
  };

  const handleSubmit = async (event) => {
    event.preventDefault();

    if (!validateForm()) {
      return;
    }

    setIsSubmitting(true);

    try {
      await addTask({
        title: title.trim(),
        description: description.trim(),
      });
      setTitle("");
      setDescription("");
      setErrors({ title: "", description: "" });
    } catch (error) {
      console.error("Error al agregar tarea:", error);
    }

    setIsSubmitting(false);
  };

  const handleTitleChange = (e) => {
    setTitle(e.target.value);
    if (errors.title && e.target.value.trim()) {
      setErrors({ ...errors, title: "" });
    }
  };

  const handleDescriptionChange = (e) => {
    setDescription(e.target.value);
    if (errors.description && e.target.value.trim()) {
      setErrors({ ...errors, description: "" });
    }
  };

  const isFormValid = title.trim() && description.trim();

  return (
    <form className="task-form" onSubmit={handleSubmit}>
      <div className="form-group">
        <input
          type="text"
          value={title}
          onChange={handleTitleChange}
          placeholder="Título de la tarea *"
          required
          className={`form-input ${errors.title ? "error" : ""}`}
          disabled={isSubmitting}
        />
        {errors.title && <span className="error-message">{errors.title}</span>}
      </div>
      <div className="form-group">
        <textarea
          value={description}
          onChange={handleDescriptionChange}
          placeholder="Descripción de la tarea *"
          rows="3"
          required
          className={`form-textarea ${errors.description ? "error" : ""}`}
          disabled={isSubmitting}
        />
        {errors.description && (
          <span className="error-message">{errors.description}</span>
        )}
      </div>
      <div className="form-info">
        <p className="required-fields">* Todos los campos son obligatorios</p>
      </div>
      <button
        type="submit"
        className="form-button"
        disabled={isSubmitting || !isFormValid}
      >
        {isSubmitting ? "Agregando..." : "Agregar Tarea"}
      </button>
    </form>
  );
};

export default TaskForm;
